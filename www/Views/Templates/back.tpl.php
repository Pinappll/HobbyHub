<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/easycook-vite/dist/css/style.css">
  <script src="/easycook-vite/dist/js/main.js"></script>
  <script src="https://kit.fontawesome.com/ebcd47c5e0.js" crossorigin="anonymous"></script>
  <title><?php echo htmlspecialchars($this->data['title']); ?></title>

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