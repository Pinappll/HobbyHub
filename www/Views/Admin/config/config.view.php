<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" type="text/css" href="../../easycook-vite/dist/css/style.css">
  <script src="https://kit.fontawesome.com/ebcd47c5e0.js" crossorigin="anonymous"></script>
  <script src="../../easycook-vite/dist/js/main.js"></script>
  <title>Installeur</title>
</head>

<body class="page-wrapper">
<section class="section">
<?php 
var_dump($this->data);

$this->includeComponent("form", $configForm, $errorsForm);
if (isset($this->data["message"])) {
    echo "<h3>" . $this->data["message"] . "</h3>";
}
?>
</section>
</body>
</html>

