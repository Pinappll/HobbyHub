<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
  <link rel="stylesheet" href="../../easycook-vite/src/css/grapesJs.css">
  <link rel="stylesheet" type="text/css" href="/easycook-vite/dist/css/style.css">
  <script src="/easycook-vite/dist/js/main.js"></script>
  <script src="https://kit.fontawesome.com/ebcd47c5e0.js" crossorigin="anonymous"></script>
  <title><?php echo htmlspecialchars($this->data['title']); ?></title>
  <style>
    :root {
        --couleur-principale: <?= $couleurCSS['couleur_principale'] ?>;
        --couleur-secondaire: <?= $couleurCSS['couleur_secondaire'] ?>;
        --couleur-accent: <?= $couleurCSS['couleur_accent'] ?>;
        --couleur-accent-clair: <?= $couleurCSS['couleur_accent_clair'] ?>;
    }
</style>
</head>

<body>

  <?php $this->includeComponent("header-back", [], $this->data); ?>
  <div class="admin-container">
  <!-- Include the admin sidebar -->
  <?php $this->includeComponent("sidebar-admin", [], $this->data); ?>
  <main  class="admin-content">
    <?php include $this->viewName; ?>
  </main>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar-admin");
    const mainContent = document.querySelector(".admin-content");

    if (sidebar && mainContent) {
      mainContent.classList.add("has-sidebar");
    }
  });
  </script>

</body>

</html>