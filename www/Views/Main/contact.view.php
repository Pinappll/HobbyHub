<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../dist/css/main.css">
    <title>Formulaire de Contact</title>
</head>
<body>

    <section>
    <h1>Contact</h1>
    <p>Remplissez le formulaire ci-dessous pour nous contacter.</p>
    </section>
    
    <section> 
    <form action="#" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button class="button button-primary" type="submit">Envoyer</button>
    </form>
    </section>
</body>
</html>
