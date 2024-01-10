<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" type="text/css" href="../dist/css/main.css">
    <title>EasyAdmin</title>
</head>
<body>

        <header class="site-header">
            <div class="container ">
                <a href="/admin" class="site-logo">
                    <img src="images/logo.svg" alt="EasyAdmin">
                </a>
            
                <nav>
                    <ul class="">
                        <li><a href="/admin/dashboard">Accueil</a></li>
                        <li><a href="/admin/pages">Pages</a></li>
                        <li><a href="/admin/themes">Themes</a></li>
                        <li><a href="/admin/menus">Menu</a></li>
                        <li><a href="/admin/recipies">Recipes</a></li>
                        <li><a href="/admin/users">Users</a></li>
                        <li><a href="/admin/reviews">Reviews</a></li>
                        <li><a href="#">General</a></li>
                    </ul>
                </nav>
                
            </div>
        </header>
    
    <?php include $this->viewName;?>

</body>
</html>