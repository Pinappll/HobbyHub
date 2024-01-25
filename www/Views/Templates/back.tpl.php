<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../easycook-vite/dist/style.css">
    <title>EasyAdmin</title>
</head>
<body class='admin'>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-title">
            <a href="/admin" class="site-logo">
                <img src="images/logo.svg" alt="EasyAdmin">
            </a>
        </div>
        <ul>
            <li><a href="/admin/dashboard">Dashboard</a></li>
            <li><a href="/admin/pages">Pages</a></li>
            <li><a href="/admin/menus">Menu</a></li>
            <li><a href="/admin/recipies">Recipes</a></li>
            <li><a href="/admin/users">Users</a></li>
            <li><a href="/admin/reviews">Reviews</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

    <!-- Contenu Principal -->
    <div class='content'>
    <?php include $this->viewName;?>
</div>
</body>
</html>