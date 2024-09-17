document.addEventListener("DOMContentLoaded", () => {
  // Gestion du burger menu
  const burger = document.querySelector(".header__burger");
  const nav = document.querySelector(".header__nav");

  burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    nav.classList.toggle("active");
  });

  // Gestion des dropdowns en mobile
  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

  dropdownToggles.forEach(toggle => {
    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      const parent = toggle.closest(".has-dropdown");
      parent.classList.toggle("dropdown-active");
    });
  });
});
