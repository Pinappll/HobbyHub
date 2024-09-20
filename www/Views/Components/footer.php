<?php
// Instancier le modèle Setting pour récupérer le nom du site
$settingModel = new \App\Models\Setting();
$siteName = $settingModel->getSiteName();

// Récupérer les liens des réseaux sociaux
$socialLinks = $settingModel->getSocialLinks();

// Définir les liens par défaut s'ils ne sont pas présents en base
$linkFacebook = $socialLinks['facebook'] ?? 'https://facebook.com';
$linkInstagram = $socialLinks['instagram'] ?? 'https://instagram.com';
$linkTwitter = $socialLinks['twitter'] ?? 'https://twitter.com';
?>

<footer class="footer">
  <div class="footer__container">
    <div class="footer__logo">
      <a href="/">
      <img src="../../dist/assets/images/logo.png" alt="Logo EasyCook">
      </a>
    </div>

    <div class="footer__socials">
      <a href="<?= htmlspecialchars($linkFacebook) ?>" target="_blank">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="<?= htmlspecialchars($linkInstagram) ?>" target="_blank">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="<?= htmlspecialchars($linkTwitter) ?>" target="_blank">
        <i class="fab fa-twitter"></i>
      </a>
    </div>

    <div class="footer__copyright">
      <p>&copy; 2024 <?= htmlspecialchars($siteName) ?>. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<!-- Assurez-vous de charger les icônes Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
