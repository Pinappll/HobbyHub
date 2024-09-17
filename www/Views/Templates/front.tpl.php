<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" type="text/css" href="../../easycook-vite/dist/css/style.css">
  <script src="https://kit.fontawesome.com/ebcd47c5e0.js" crossorigin="anonymous"></script>
  <script src="../../easycook-vite/dist/js/main.js"></script>
  <title><?php echo htmlspecialchars($this->data['title']); ?></title>
</head>

<body class="page-wrapper">
  
  <?php $this->includeComponent("header", [], $this->data); ?>
  <main>
    <?php  include $this->viewName; ?>
  </main>
  <?php  $this->includeComponent("footer", [], []); ?>
 
</body>

</html>