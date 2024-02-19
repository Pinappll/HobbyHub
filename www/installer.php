<?php
// Vérifiez la version PHP
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    die("La version de PHP doit être 7.4.0 ou supérieure. Version actuelle : " . PHP_VERSION);
}

// Affichez le formulaire de configuration de la base de données si les données ne sont pas encore soumises
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<form action="" method="post">
            Serveur de la base de données: <input type="text" name="db_host"><br>
            Nom de la base de données: <input type="text" name="db_name"><br>
            Utilisateur de la base de données: <input type="text" name="db_user"><br>
            Mot de passe de la base de données: <input type="password" name="db_password"><br>
            <input type="submit" value="Installer">
          </form>';
} else {
    // Récupérez les données du formulaire
    $dbHost = $_POST['db_host'];
    $dbName = $_POST['db_name'];
    $dbUser = $_POST['db_user'];
    $dbPassword = $_POST['db_password'];

    // Tentez de vous connecter à la base de données
    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Créez une table de test (ajustez selon vos besoins)
        $pdo->exec("CREATE TABLE IF NOT EXISTS test (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    data VARCHAR(255) NOT NULL
                    ) ENGINE=InnoDB;");

        // Créez un fichier de configuration simple (à améliorer pour la sécurité)
        $configData = "<?php\n\$dbHost = '$dbHost';\n\$dbName = '$dbName';\n\$dbUser = '$dbUser';\n\$dbPassword = '$dbPassword';\n";
        file_put_contents('config.php', $configData);

        echo "Installation réussie !";
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
