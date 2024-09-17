document.addEventListener("DOMContentLoaded", () => {
  const switchToSignup = document.querySelector('.switch-to-signup');
  const switchToLogin = document.querySelectorAll('.switch-to-login'); // All elements that switch to login
  const switchToForgotPassword = document.querySelector('.switch-to-forgot-password');
  
  const formLogin = document.querySelector('.form-login');
  const formSignup = document.querySelector('.form-signup');
  const formForgotPassword = document.querySelector('.form-forgot-password');

  // Switch to Signup Form
  switchToSignup.addEventListener('click', (e) => {
    e.preventDefault();
    formLogin.classList.remove('active');
    formSignup.classList.add('active');
    formForgotPassword.classList.remove('active');
  });

  // Switch to Login Form
  switchToLogin.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        formSignup.classList.remove('active');
        formLogin.classList.add('active');
        formForgotPassword.classList.remove('active');
      });
  });

  // Switch to Forgot Password Form
  switchToForgotPassword.addEventListener('click', (e) => {
    e.preventDefault();
    formLogin.classList.remove('active');
    formSignup.classList.remove('active');
    formForgotPassword.classList.add('active');
  });
});
