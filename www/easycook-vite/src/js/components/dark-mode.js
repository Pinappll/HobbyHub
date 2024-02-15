document.addEventListener('DOMContentLoaded', () => {
    const darkModeSwitch = document.querySelector('.dark-mode');
  
    if (darkModeSwitch) {
      let isDarkMode = localStorage.getItem('darkMode') === 'true' ||
                       (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches);
  
      document.documentElement.classList.toggle('data-dark-mode', isDarkMode);
      darkModeSwitch.textContent = isDarkMode ? 'Mode Clair' : 'Mode Sombre';
  
      darkModeSwitch.addEventListener('click', () => {
        isDarkMode = !isDarkMode;
        localStorage.setItem('darkMode', isDarkMode);
        document.documentElement.classList.toggle('data-dark-mode', isDarkMode);
        darkModeSwitch.textContent = isDarkMode ? 'Mode Clair' : 'Mode Sombre';
      });
    }
  });
  