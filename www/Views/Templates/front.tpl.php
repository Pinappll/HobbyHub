<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" type="text/css" href="../dist/css/main.css">
    <title>Template Front</title>
</head>
<body>

        <header class="site-header">
            <div class="container ">
                <a href="#" class="site-logo">
                    <img src="images/logo.svg" alt="EasyCook">
                </a>
            
                <nav>
                    <ul class="">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Recettes</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">|</a></li>
                        <li><a href="#">S'inscrire</a></li>
                        <li><a href="#">Se connecter</a></li>
                    </ul>
                </nav>
                
            </div>
        </header>
    
    <?php include $this->viewName;?>

</body>
</html>