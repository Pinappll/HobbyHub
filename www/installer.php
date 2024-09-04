<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbHost = $_POST['dbHost'];
    $dbUser = $_POST['dbUser'];
    $dbPassword = $_POST['dbPassword'];
    // Le nom de la base de données sera converti en minuscules
    $dbName = strtolower($_POST['dbName']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $siteName = $_POST['siteName'];
    $slogan = $_POST['slogan'];


    // $userAdmin = new User();
    // $userAdmin->setLastname_user($nom);
    // $userAdmin->setFirstname_user($prenom);
    // $userAdmin->setEmail_user($mail);
    // $userAdmin->setPassword_user($mot_de_passe);
    // $userAdmin->setType_user('admin');
    // $userAdmin->setToken_user('token');
    // $userAdmin->setIs_verified_user(true);
    // $userAdmin->setIsDeleted(false);



    // Stocker l'image du logo dans le dossier dist/assets/images avec comme nom logo

    $targetDir = "dist/assets/images"; // Spécifiez le dossier où stocker les images
    $targetFile = $targetDir . basename($_FILES["imageToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

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

    // Vérifiez si le fichier existe déjà
    if (file_exists($targetFile)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Limitez les formats de fichier
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }


    $logoPath = "dist/assets/images/" . htmlspecialchars(basename($_FILES["imageToUpload"]["name"]));

    $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

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

        $pdo = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifiez si $uploadOk est défini sur 0 par une erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
            // Si tout est ok, essayez de télécharger le fichier
        } else {
            if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $targetFile)) {
                echo "Le fichier " . htmlspecialchars(basename($_FILES["imageToUpload"]["name"])) . " a été téléchargé.";
            } else {
                echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
            }
        }

        // Lire et préparer le script SQL
        $sqlFile = './sql_scripts/script.sql';
        $sql = file_get_contents($sqlFile);
        $sql = str_replace('{PREFIX}', $dbName, $sql);

        // Exécuter le script SQL
        $pdo->exec($sql);

        // Supprimer le fichier SQL après l'exécution
        if (file_exists($sqlFile)) {
            unlink($sqlFile);
        }
        
         // Insertion de l'utilisateur admin
         $token = bin2hex(random_bytes(16)); // Génère un token pour l'admin
         $stmt = $pdo->prepare("
             INSERT INTO users (lastname, firstname, email, password, type, token, is_verified, is_deleted)
             VALUES (:lastname, :firstname, :email, :password, 'admin', :token, true, false)
         ");
         $stmt->execute([
             ':lastname' => $nom,
             ':firstname' => $prenom,
             ':email' => $mail,
             ':password' => $mot_de_passe,
             ':token' => $token
         ]);
 
         echo "L'utilisateur administrateur a été créé avec succès.";

        echo "La base de données '$dbName' a été créée avec succès.";
        echo "Les tables ont été créées avec succès dans la base de données '{$dbName}'.";



        // Créez un fichier de configuration simple (à améliorer pour la sécurité)
        $configData = "<?php\n\$dbHost = '$dbHost';\n\$dbName = '$dbName';\n\$dbUser = '$dbUser';\n\$dbPassword = '$dbPassword';\n";
        file_put_contents('config.php', $configData);

        if (file_exists(__FILE__)) {
            unlink(__FILE__); // Supprime le fichier installer.php
            header('Location: /login');
        }
    } catch (PDOException $e) {
        die("Erreur lors de la création de la base de données : " . $e->getMessage());
    }
} else {
?>
    <style>
        form {
            display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px 400px;
        }

        input {
            height: 25px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 15px;
        }

        body {
    font-family: Arial, sans-serif;
    background-color: beige;
}
    </style>
    <form method="post" enctype="multipart/form-data">
        <label for="dbHost">Hôte de la base de données :</label><br>
        <input type="text" id="dbHost" name="dbHost" required><br>

        <label for="dbName">Nom de la base de données :</label><br>
        <input type="text" id="dbName" name="dbName" required><br>

        <label for="dbUser">Utilisateur de la base de données :</label><br>
        <input type="text" id="dbUser" name="dbUser" required><br>

        <label for="dbPassword">Mot de passe de la base de données :</label><br>
        <input type="password" id="dbPassword" name="dbPassword" required><br><br>

        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="mail">Mail :</label><br>
        <input type="email" id="mail" name="mail" required><br>

        <label for="mot_de_passe">Mot de passe :</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

        <label for="siteName">Nom du site :</label><br>
        <input type="text" id="siteName" name="siteName" required><br>

        <label for="slogan">Slogan :</label><br>
        <input type="text" id="slogan" name="slogan" required><br>

        <label for="logo">Logo :</label><br>
        <input type="file" id="imageToUpload" name="imageToUpload" required><br><br>



        <input type="submit" value="Créer la base de données">
    </form>
<?php
}
?>
