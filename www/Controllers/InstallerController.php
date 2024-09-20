<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Contact;
use App\Forms\FormInit;
use PDO;
use PDOException;

class InstallerController
{
    public function install(): void
{
    if (!file_exists('/var/www/html/installer.php')) {
        header('Location: /login');
    }
    $myView = new View("Admin/config/config", null);
    $form = new FormInit();
    $config = $form->getConfig($_REQUEST);
    $errors = [];
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dbHost = $_POST['dbHost'];
        $dbUser = $_POST['dbUser'];
        $dbPassword = $_POST['dbPassword'];
        $dbName = strtolower($_POST['dbName']);
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $mot_de_passe = $_POST['password'];
        $siteName = $_POST['siteName'];
        $slogan = $_POST['slogan'];
        $colorSetting = $_POST['color'] ?? null;

        $verificator = new Verificator();

        if ($verificator->checkForm($config, array_merge($_REQUEST, $_FILES), $errors)) {
            $targetDir = "dist/assets/images/";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($_FILES["imageToUpload"]["name"], PATHINFO_EXTENSION));

            // Vérification si le fichier est bien une image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $errors = ["Le fichier n'est pas une image."];
                    $uploadOk = 0;
                }
            }

            // Vérification des formats autorisés
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {

                $errors = ["Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés."];
                $uploadOk = 0;
            }

            // Si le fichier est valide, nous remplaçons l'ancien logo
            if ($uploadOk == 1) {
                // Chemin cible pour le fichier logo
                $targetFile = $targetDir . "logo." . $imageFileType;

                // Vérifier si un fichier nommé "logo.EXT" existe déjà
                $existingFiles = glob($targetDir . "logo.*"); // Rechercher tous les fichiers "logo.*"
                
                // Supprimer le fichier existant (s'il y en a un)
                foreach ($existingFiles as $existingFile) {
                    unlink($existingFile); // Supprime l'ancien fichier logo
                }

                // Téléchargement de la nouvelle image
                if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $targetFile)) {
                    $message= "Le fichier a été téléchargé et renommé en logo." . $imageFileType;
                } else {
                    $errors= ["Désolé, il y a eu une erreur lors du téléchargement de votre fichier."];
                }
                $logoPath = "dist/assets/images/logo." . $imageFileType; // URL du nouveau logo

                $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    
                // Écriture dans le fichier config.php
                $configFile = "<?php\n";
                $configFile .= "\$dbHost = '" . addslashes($dbHost) . "';\n";
                $configFile .= "\$dbName = '" . addslashes($dbName) . "';\n";
                $configFile .= "\$dbUser = '" . addslashes($dbUser) . "';\n";
                $configFile .= "\$dbPassword = '" . addslashes($dbPassword) . "';\n";
    
                file_put_contents('config.php', $configFile); // Crée ou remplace le fichier config.php
    
                try {
                    // Connexion initiale à PostgreSQL
                    $pdo = new \PDO('pgsql:host=' . $dbHost . ';dbname=postgres;user=' . $dbUser . ';password=' . $dbPassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Tester la connexion
                    $pdo->query('SELECT 1');
                
                    // Création de la base de données (hors transaction)
                    $sql = "CREATE DATABASE $dbName";
                    $pdo->exec($sql);
                
                    // Connexion à la nouvelle base de données
                    $pdo = new \PDO('pgsql:host=' . $dbHost . ';dbname=' . $dbName . ';user=' . $dbUser . ';password=' . $dbPassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Démarrer la transaction
                    $pdo->beginTransaction();
                    
                    // Lire et exécuter le script SQL
                    $sqlFile = '/var/www/html/sql_scripts/script.sql';
                    $sql = file_get_contents($sqlFile);
                    $sql = str_replace('{PREFIX}', $dbName, $sql);
                    $pdo->exec($sql);
                    
                    // Insertion des paramètres du site
                    $stmt = $pdo->prepare("
                        INSERT INTO {$dbName}_setting (name_setting, slogan_setting, logo_url_setting, color_setting)
                        VALUES (:siteName, :slogan, :logoUrl, :colorSetting)
                    ");
                    $stmt->execute([
                        ':siteName' => $siteName,
                        ':slogan' => $slogan,
                        ':logoUrl' => $logoPath,
                        ':colorSetting' => $colorSetting
                    ]);
                    
                    // Insertion de l'utilisateur admin
                    $token = bin2hex(random_bytes(16));
                    $stmt = $pdo->prepare("
                        INSERT INTO {$dbName}_user (lastname_user, firstname_user, email_user, password_user, type_user, token_user, is_verified_user, is_deleted)
                        VALUES (:lastname, :firstname, :email, :password, 'admin', :token, true, false)
                    ");
                    $stmt->execute([
                        ':lastname' => $nom,
                        ':firstname' => $prenom,
                        ':email' => $mail,
                        ':password' => $mot_de_passe,
                        ':token' => $token
                    ]);
                    
                    // Valider la transaction si tout est correct
                    $pdo->commit();
                    $message = "Installation réussie, l'administrateur a été créé.";
                
                    // Supprimer le fichier d'installation
                    if (file_exists('/var/www/html/installer.php')) {
                        unlink('/var/www/html/installer.php');
                        header('Location: /login');
                    }
                
                } catch (PDOException $e) {
                    // En cas d'erreur, annuler toutes les opérations
                    $errors = ["Erreur lors de l'installation : " . $e->getMessage()];
    
                    if (isset($pdo) && $pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    try {
                        $pdo = new \PDO('pgsql:host=' . $dbHost . ';dbname=postgres;user=' . $dbUser . ';password=' . $dbPassword);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->exec("DROP DATABASE IF EXISTS $dbName");
                    } catch (PDOException $dropError) {
                        $errors[] = "Erreur lors de la suppression de la base de données : " . $dropError->getMessage();
                    }
                    $myView->assign("configForm", $config);
                    $myView->assign("errorsForm", $errors);
                    $myView->assign("message", $message);
                }
                    $myView->assign("configForm", $config);
                    $myView->assign("errorsForm", $errors);
                    $myView->assign("message", $message);
            }else{
                $myView->assign("configForm", $config);
                $myView->assign("errorsForm", $errors);
                $myView->assign("message", $message);
            }

           
            
        }
    }

    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errors);
    $myView->assign("message", $message);
}

}
