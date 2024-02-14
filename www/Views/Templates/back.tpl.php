<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" type="text/css" href="/easycook-vite/dist/css/style.css">
  <script src="/easycook-vite/dist/js/main.js"></script>
  <title>Template Back</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-admin">

      <div class="container">
        <button class="navbar_toggle_button" data-target="#content">
          Menu
        </button>
        <img src="../../dist/assets/images/logoEasyCook.png" alt="logoEasyCook">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
          <circle cx="12" cy="10" r="3" />
          <circle cx="12" cy="12" r="10" />
        </svg>
        <ul class='navbar-desktop'>
          <li><a href="/admin/dashboard">Dashboard</a></li>
          <li><a href="/admin/pages">Pages</a></li>
          <li><a href="/admin/menus">Menu</a></li>
          <li><a href="/admin/recipes">Recipes</a></li>
          <li><a href="/admin/users">Users</a></li>
          <li><a href="/admin/reviews">Reviews</a></li>
          <li><a href="#">Settings</a></li>
        </ul>
      </div>

      <div class="navbar_toggle_content" id="content">
        <ul>
          <li><a href="/admin/dashboard">Dashboard</a></li>
          <li><a href="/admin/pages">Pages</a></li>
          <li><a href="/admin/menus">Menu</a></li>
          <li><a href="/admin/recipes">Recipes</a></li>
          <li><a href="/admin/users">Users</a></li>
          <li><a href="/admin/reviews">Reviews</a></li>
          <li><a href="#">Settings</a></li>
        </ul>
      </div>
    </nav>

  </header>

  <main>
    <?php include $this->viewName; ?>
  </main>
</body>

</html>