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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
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
            echo "Le fichier ". htmlspecialchars(basename($_FILES["imageToUpload"]["name"])). " a été téléchargé.";
        } else {
            echo "Désolé, il y a eu une erreur lors du téléchargement de votre fichier.";
        }
    }


        // Tableaux contenant les requêtes SQL pour créer les tables
        $queries = [
            
            "CREATE TABLE {$dbName}_user (
                id SERIAL PRIMARY KEY,
                lastname_user VARCHAR(50) NOT NULL,
                firstname_user VARCHAR(50) NOT NULL,
                email_user VARCHAR(320) NOT NULL UNIQUE,
                is_verified_user BOOLEAN NOT NULL DEFAULT FALSE,
                password_user VARCHAR(255) NOT NULL,
                token_user VARCHAR(64) NOT NULL,
                type_user TEXT NOT NULL CHECK (type_user IN ('viewer', 'chef', 'admin')),
                is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
                inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
                updated_at TIMESTAMPTZ
            )",
           "CREATE OR REPLACE FUNCTION update_updated_at_column()
           RETURNS TRIGGER AS $$
           BEGIN
               NEW.updated_at = current_timestamp;
               RETURN NEW;
           END;
           $$ LANGUAGE plpgsql",
            
           "CREATE TRIGGER update_updated_at_{$dbName}_user
           BEFORE UPDATE ON {$dbName}_user
           FOR EACH ROW
           EXECUTE FUNCTION update_updated_at_column()",

           "INSERT INTO {$dbName}_user (lastname_user, firstname_user, email_user, password_user, type_user, token_user, is_verified_user, is_deleted) 
           VALUES ('$nom', '$prenom', '$mail', '$mot_de_passe', 'admin', 'token' , TRUE, FALSE)",
       
           "CREATE TABLE {$dbName}_setting (
               name_setting VARCHAR(50) NOT NULL,
               slogan_setting VARCHAR(255) NOT NULL,
               logo_url_setting TEXT NOT NULL,
               color_setting VARCHAR(50) NOT NULL
           )",

            "INSERT INTO {$dbName}_setting (name_setting, slogan_setting, logo_url_setting, color_setting)
            VALUES ('$siteName', '$slogan', '$logoPath', 'blue')",
       
           "CREATE TABLE {$dbName}_recipe (
               id SERIAL PRIMARY KEY,
               id_user_recipe INT NOT NULL,
               title_recipe VARCHAR(50) NOT NULL,
               ingredient_recipe TEXT NOT NULL,
               instruction_recipe TEXT NOT NULL,
               image_url_recipe TEXT NOT NULL,
               is_deleted BOOLEAN DEFAULT FALSE,
               inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
               updated_at TIMESTAMPTZ DEFAULT NULL,
               CONSTRAINT fk_user_recipe FOREIGN KEY (id_user_recipe) REFERENCES {$dbName}_user(id)
           )",
       
           "CREATE TRIGGER update_updatedat_{$dbName}_recipe
           BEFORE UPDATE ON {$dbName}_recipe
           FOR EACH ROW
           EXECUTE FUNCTION update_updated_at_column()",

           "CREATE TABLE {$dbName}_category (
            id SERIAL PRIMARY KEY,
            name_category VARCHAR(50) NOT NULL,
            is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
            updated_at TIMESTAMPTZ DEFAULT NULL
            )",

            "CREATE TRIGGER update_updated_at_{$dbName}_category
            BEFORE UPDATE ON {$dbName}_category
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column()",

            "CREATE TABLE {$dbName}_recipe_category (
                id SERIAL PRIMARY KEY,
                id_recipe_category INT NOT NULL,
                id_category INT NOT NULL,
                CONSTRAINT fk_recipe_category_recipe FOREIGN KEY (id_recipe_category) REFERENCES {$dbName}_recipe(id),
                CONSTRAINT fk_recipe_category_category FOREIGN KEY (id_category) REFERENCES {$dbName}_category(id)
            )",

            "CREATE TABLE {$dbName}_page (
                id SERIAL PRIMARY KEY,
                title_page TEXT NOT NULL,
                content_page TEXT NOT NULL,
                markup_meta_pages TEXT NOT NULL,
                id_user INT NOT NULL,
                CONSTRAINT fk_user_page FOREIGN KEY (id_user) REFERENCES {$dbName}_user(id)
            )",

            "CREATE TABLE {$dbName}_review (
                id SERIAL PRIMARY KEY,
                id_user_review INT NOT NULL,
                id_recipe_review INT NOT NULL,
                title_review VARCHAR(50) NOT NULL,
                content_review TEXT NOT NULL,
                status_review TEXT NOT NULL CHECK (status_review IN ('accept', 'process', 'cancel', '')),
                is_deleted BOOLEAN NOT NULL DEFAULT FALSE,
                inserted_at TIMESTAMPTZ DEFAULT current_timestamp,
                updated_at TIMESTAMPTZ DEFAULT NULL,
                CONSTRAINT fk_user_review FOREIGN KEY (id_user_review) REFERENCES {$dbName}_user(id),
                CONSTRAINT fk_recipe_review FOREIGN KEY (id_recipe_review) REFERENCES {$dbName}_recipe(id)
            )",

            "CREATE TRIGGER update_updated_at_{$dbName}_review
            BEFORE UPDATE ON {$dbName}_review
            FOR EACH ROW
            EXECUTE FUNCTION update_updated_at_column()",

            "CREATE TABLE {$dbName}_menu (
                id SERIAL PRIMARY KEY,
                title_menu VARCHAR(50) NOT NULL,
                description_menu TEXT NOT NULL
            )",

            "CREATE TABLE {$dbName}_recipe_menu (
                id SERIAL PRIMARY KEY,
                id_recipe INT NOT NULL,
                id_menu INT NOT NULL,
                CONSTRAINT fk_recipe_menu_recipe FOREIGN KEY (id_recipe) REFERENCES {$dbName}_recipe(id),
                CONSTRAINT fk_recipe_menu_menu FOREIGN KEY (id_menu) REFERENCES {$dbName}_menu(id)
            )",

            "CREATE TABLE {$dbName}_navigation (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                link VARCHAR(255),
                position INT,
                parent_id INT,
                level INT
            )",
        ];
        foreach ($queries as $query) {
            $pdo->exec($query);
        }

        echo "La base de données '$dbName' a été créée avec succès.";
        echo "Les tables ont été créées avec succès dans la base de données '{$dbName}'.";

        
        
        // Créez un fichier de configuration simple (à améliorer pour la sécurité)
        $configData = "<?php\n\$dbHost = '$dbHost';\n\$dbName = '$dbName';\n\$dbUser = '$dbUser';\n\$dbPassword = '$dbPassword';\n";
        file_put_contents('config.php', $configData);

        if (file_exists(__FILE__)) {
            unlink(__FILE__); // Supprime le fichier installer.php
            header('Location: /');
        }
        

    } catch (PDOException $e) {
        die("Erreur lors de la création de la base de données : " . $e->getMessage());
    }
} else {
    ?>
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
