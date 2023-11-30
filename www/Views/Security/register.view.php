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

        <section>
        <form id="register-form" action="process_register.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirmez le mot de passe :</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        </section>
    </div>
</body>
</html>