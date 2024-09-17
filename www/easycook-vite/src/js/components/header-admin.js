document.addEventListener("DOMContentLoaded", () => {
    const burger = document.querySelector(".header-admin__burger");
    const sidebar = document.querySelector(".sidebar-admin");
  
    burger.addEventListener("click", () => {
      burger.classList.toggle("active");
      sidebar.classList.toggle("active");
    });
  });
  