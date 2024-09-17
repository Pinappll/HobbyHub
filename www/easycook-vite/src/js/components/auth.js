document.addEventListener("DOMContentLoaded", () => {
    const switchToSignup = document.querySelector('.switch-to-signup');
    const switchToLogin = document.querySelector('.switch-to-login');
    const formLogin = document.querySelector('.form-login');
    const formSignup = document.querySelector('.form-signup');
  
    switchToSignup.addEventListener('click', (e) => {
      e.preventDefault();
      formLogin.classList.remove('active');
      formSignup.classList.add('active');
    });
  
    switchToLogin.addEventListener('click', (e) => {
      e.preventDefault();
      formSignup.classList.remove('active');
      formLogin.classList.add('active');
    });
});
  