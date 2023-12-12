<?php
use App\Core\BuildForm;
use App\Forms\UserInsert;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <section>
        <h2>Inscription</h2>
        <p>Remplissez le formulaire ci-dessous pour créer votre compte.</p>
        </section>
        
        <?php

        $userForm = new UserInsert();
        $userForm->render();

        ?>
        
    </div>
</body>
</html>