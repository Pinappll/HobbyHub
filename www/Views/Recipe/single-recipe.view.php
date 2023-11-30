<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recette - Nom de la Recette</title>
    <style>
        /* CSS pour centrer la première section */
        .section1 {
            text-align: center;
        }
        /* CSS pour la mise en page de la deuxième section */
        .section2 {
            display: flex;
            align-items: center;
        }
        .recette-image {
            flex: 1;
            max-width: 50%;
        }
        .recette-details {
            flex: 1;
        }
        .avis {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="section1">
        <h1>Nom de la Recette</h1>
        <p>Veuillez retrouver les ingrédients de la recette ci-dessous.</p>
    </div>

    <div class="section2">
        <div class="recette-image">
            <img src="image_de_la_recette.jpg" alt="Image de la Recette">
        </div>
        <div class="recette-details">
            <h2>Titre de la Recette</h2>
            <p>Description de la recette...</p>
            <ul>
                <li>Ingrédient 1</li>
                <li>Ingrédient 2</li>
                <li>Ingrédient 3</li>
                <!-- Ajoutez autant d'ingrédients que nécessaire -->
            </ul>
        </div>
    </div>

    <div class="avis">
        <h2>Avis des Utilisateurs</h2>
        <!-- Insérez ici un formulaire ou un système pour que les utilisateurs laissent des avis et des notes sous forme d'étoiles -->
    </div>
</body>
</html>
