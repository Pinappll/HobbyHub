<?php
require_once __DIR__ . '/../../Models/User.php';
$user = null;
if (isset($_SESSION['user_id'])) {
    $userModel = new \App\Models\User();
    $user = $userModel->getOneBy(['id' => $_SESSION['user_id']], 'object');
}
?>
<aside class="sidebar-admin">
  <nav>
    <ul class="sidebar-admin__menu">
      <?php if ($user && $user->getType_user() === 'admin'): ?>
        <li><a href="/admin/dashboard">Dashboard</a></li>
        <li><a href="/admin/pages">Pages</a></li>
        <li><a href="/admin/users">Users</a></li>
        <li><a href="/admin/reviews">Reviews</a></li>
        <li><a href="/admin/navigation">Navigation</a></li>
        <li><a href="/admin/settings">Settings</a></li>
        <li><a href="/admin/footer">Footer</a></li>
        <li><a href="/admin/export">Export</a></li>
      <?php endif; ?>

      <?php if ($user && in_array($user->getType_user(), ['admin', 'chef'])): ?>
        <li><a href="/admin/recipes">Recipes</a></li>
        <li><a href="/admin/category">Categories</a></li>
        <li><a href="/admin/menus">Menu</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</aside>
