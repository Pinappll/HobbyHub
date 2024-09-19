document.addEventListener("DOMContentLoaded", () => {
  // Insertion dans le formulaire de création de menu
  if (document.querySelector("#form-menu-insert")) {
    var table = document.createElement("table");
    table.classList.add("recipe-table");
    table.id = "recipe";

    // Création de l'en-tête du tableau
    var thead = document.createElement("thead");
    var headerRow = document.createElement("tr");
    var headers = ["", "Titre", "Ingrédient", "Instruction", "Image"];

    headers.forEach(function (headerText) {
      var th = document.createElement("th");
      th.textContent = headerText;
      headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Création du body pour les lignes de recettes
    var tbody = document.createElement("tbody");
    table.appendChild(tbody);

    // Ajout du tableau à la page
    document.querySelector(".recipe").appendChild(table);

    // Gestion du changement de catégorie
    $("#form-menu-insert .select-category").on("change", function () {
      var value = $(this).val();
      $.ajax({
        url: "/admin/menus/add",
        type: "POST",
        data: "category=" + value,
        success: function (data) {
          $(".content-recipe").html(data);

          // Gérer les événements de changement pour les checkboxes
          document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
              var row = event.target.closest("tr");
              var destinationTable = event.target.checked
                ? document.querySelector("#recipe tbody")
                : document.querySelector(".content-recipe table tbody");
              destinationTable.appendChild(row);
            });
          });
        },
      });
    });
  }

  // Modification dans le formulaire d'édition de menu
  if (document.querySelector("#form-menu-edit")) {
    var id = $("#id_menu").val();
    $.ajax({
      url: "/admin/menus/edit?id=" + id,
      type: "POST",
      success: function (data) {
        $(".recipe").html(data);
      },
    });

    // Gestion du changement de catégorie
    $("#form-menu-edit .select-category").on("change", function () {
      var value = $(this).val();
      $.ajax({
        url: "/admin/menus/edit?id=" + id + "&category=" + value,
        type: "POST",
        data: "category=" + value,
        success: function (data) {
          $(".content-recipe").html(data);

          // Gérer les événements de changement pour les checkboxes
          document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
              var row = event.target.closest("tr");
              if (event.target.checked) {
                document.querySelector("#recipe tbody").appendChild(row);
              } else {
                var contentRecipeBody = document.querySelector(".content-recipe table tbody");
                if (contentRecipeBody) {
                  contentRecipeBody.appendChild(row);
                } else {
                  row.remove();
                }
              }
            });
          });
        },
      });
    });
  }
});
