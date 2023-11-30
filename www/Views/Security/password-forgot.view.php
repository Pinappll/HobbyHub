<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h1>Réinitialisation de mot de passe</h1>
    <p>Entrez votre adresse e-mail pour réinitialiser votre mot de passe.</p>
    <form action="reinitialisation.php" method="post">
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Envoyer un e-mail de réinitialisation</button>
    </form>
</body>
</html>
