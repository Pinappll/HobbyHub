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
            // Le nom de la base de données sera converti en minuscules
            $dbName = strtolower($_POST['dbName']);
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $mail = $_POST['mail'];
            $mot_de_passe = $_POST['password'];
            $siteName = $_POST['siteName'];
            $slogan = $_POST['slogan'];
            $colorSetting = $_POST['color'] ?? null; // Peut être nul

            $verificator = new Verificator();
            if ($verificator->checkForm($config, array_merge($_REQUEST, $_FILES), $errors)) {
                $targetDir = "dist/assets/images/"; // Spécifiez le dossier où stocker les images
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($_FILES["imageToUpload"]["name"], PATHINFO_EXTENSION)); // Récupérer l'extension du fichier

                // Vérifiez si le fichier est une image réelle
                if (isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        echo "Le fichier est une image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "Le fichier n'est pas une image.";
                        $uploadOk = 0;
                    }
                }

                // Limitez les formats de fichier
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
                    $uploadOk = 0;
                }

                // Si tout est ok, essayez de télécharger le fichier
                if ($uploadOk == 1) {
                    // Renommer l'image en "logo.extension"
                    $targetFile = $targetDir . "logo." . $imageFileType; // Renommez toujours en "logo"

                    // Vérifiez si un fichier nommé "logo.extension" existe déjà et supprimez-le
                    if (file_exists($targetFile)) {
                        unlink($targetFile); // Supprimer le fichier existant
                    }

                    // Déplacer le fichier téléchargé dans le répertoire de destination avec le nouveau nom
                    if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $targetFile)) {
                        echo "Le fichier a été téléchargé et renommé en logo." . $imageFileType;
                    } else {
                        echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
                    }
                }

                $logoPath = "dist/assets/images/logo." . $imageFileType; // URL du logo

                $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                // Créez un fichier .env avec les infos de connexion DB
                $envContent = "DB_HOST=$dbHost\n";
                $envContent .= "DB_NAME=$dbName\n";
                $envContent .= "DB_USER=$dbUser\n";
                $envContent .= "DB_PASSWORD=$dbPassword\n";
                file_put_contents('.env', $envContent, FILE_APPEND);

                try {
                    // Connexion initiale à PostgreSQL sans spécifier de base de données
                    $pdo = new PDO("pgsql:host=$dbHost;dbname=postgres", $dbUser, $dbPassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "CREATE DATABASE $dbName";
                    $pdo->exec($sql);

                    // Connexion à la nouvelle base de données
                    $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Lire et préparer le script SQL pour créer les tables
                    $sqlFile = '/var/www/html/sql_scripts/script.sql';
                    $sql = file_get_contents($sqlFile);
                    $sql = str_replace('{PREFIX}', $dbName, $sql);
                    $pdo->exec($sql);

                    // Insertion des paramètres du site dans la table settings
                    $stmt = $pdo->prepare("
                        INSERT INTO {$dbName}_setting (
                            name_setting, 
                            slogan_setting, 
                            logo_url_setting, 
                            color_setting
                        ) VALUES (
                            :siteName, 
                            :slogan, 
                            :logoUrl, 
                            :colorSetting
                        )
                    ");
                    $stmt->execute([
                        ':siteName' => $siteName,
                        ':slogan' => $slogan,
                        ':logoUrl' => $logoPath,
                        ':colorSetting' => $colorSetting
                    ]);

                    // Insertion de l'utilisateur admin
                    $token = bin2hex(random_bytes(16)); // Génère un token pour l'admin
                    $stmt = $pdo->prepare("
                        INSERT INTO {$dbName}_user (
                            lastname_user, 
                            firstname_user, 
                            email_user, 
                            password_user, 
                            type_user, 
                            token_user, 
                            is_verified_user, 
                            is_deleted
                        ) VALUES (
                            :lastname, 
                            :firstname, 
                            :email, 
                            :password, 
                            'admin', 
                            :token, 
                            true, 
                            false
                        )
                    ");
                    $stmt->execute([
                        ':lastname' => $nom,
                        ':firstname' => $prenom,
                        ':email' => $mail,
                        ':password' => $mot_de_passe,
                        ':token' => $token
                    ]);

                    echo "Les paramètres du site ont été enregistrés et l'utilisateur administrateur a été créé avec succès.";

                    // Supprimez le fichier d'installation
                    if (file_exists('/var/www/html/installer.php')) {
                        if (file_exists($sqlFile)) {
                            // unlink($sqlFile);
                        }
                        unlink('/var/www/html/installer.php'); // Supprime le fichier installer.php
                        header('Location: /login');
                    }
                } catch (PDOException $e) {
                    die("Erreur lors de la création de la base de données : " . $e->getMessage());
                }
            }
        }

        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }
}
