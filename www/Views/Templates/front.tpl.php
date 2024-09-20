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
  <link rel="stylesheet" href="../../easycook-vite/src/css/grapesJs.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.21.13/css/grapes.min.css" integrity="sha512-wt37la6ckobkyOM0BBkCvrv+ozN/tGRe5BtR8DtGuxZ+m9kIy8B9hb8iLpzdrdssK2N07EMG7Tsw+/6uulUeyg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="../../easycook-vite/dist/css/style.css">
  
  <script src="https://kit.fontawesome.com/ebcd47c5e0.js" crossorigin="anonymous"></script>
  <script src="../../easycook-vite/dist/js/main.js"></script>
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

<body class="page-wrapper">
  
  <?php $this->includeComponent("header", [], $this->data); ?>
  <main>
    <?php  include $this->viewName; ?>
  </main>
  <?php  $this->includeComponent("footer", [], []); ?>
 
</body>

</html>