document.addEventListener('DOMContentLoaded', () => {
  const sunIcon = document.querySelector('#sun-icon');
  const moonIcon = document.querySelector('#moon-icon');

  // Fonction pour activer le mode sombre
  function enableDarkMode() {
      document.documentElement.classList.add('data-dark-mode');
      localStorage.setItem('darkMode', 'true');
      moonIcon.style.display = 'none'; // Cache l'icône de la lune
      sunIcon.style.display = 'inline-block'; // Affiche l'icône du soleil
  }

  // Fonction pour désactiver le mode sombre
  function disableDarkMode() {
      document.documentElement.classList.remove('data-dark-mode');
      localStorage.setItem('darkMode', 'false');
      sunIcon.style.display = 'none'; // Cache l'icône du soleil
      moonIcon.style.display = 'inline-block'; // Affiche l'icône de la lune
  }

  // Vérifie le mode préféré de l'utilisateur au chargement de la page
  if (localStorage.getItem('darkMode') === 'true' || (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      enableDarkMode();
  } else {
      disableDarkMode();
  }

  // Écouteur d'événement pour le mode clair (soleil)
  sunIcon.addEventListener('click', (e) => {
      e.preventDefault(); // Empêche le comportement par défaut du lien
      disableDarkMode();
  });

  // Écouteur d'événement pour le mode sombre (lune)
  moonIcon.addEventListener('click', (e) => {
      e.preventDefault(); // Empêche le comportement par défaut du lien
      enableDarkMode();
  });
});
