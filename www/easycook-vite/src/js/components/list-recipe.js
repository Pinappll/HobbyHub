document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("#form-menu-insert")) {
    var table = document.createElement("table");
    table.id = "recipe";

    // Création de l'en-tête du tableau
    var thead = document.createElement("tbody");
    var headerRow = document.createElement("tr");
    var headers = ["", "Titre", "Ingrédient", "Instruction", "Image"];

    headers.forEach(function (headerText) {
      var th = document.createElement("th");
      th.textContent = headerText;
      headerRow?.appendChild(th);
    });
    document.querySelector(".recipe")?.appendChild(table);
    thead?.appendChild(headerRow);
    table?.appendChild(thead);
    $("#form-menu-insert .select-category").on("change", function () {
      var value = $(this).val();
      $.ajax({
        url: "/admin/menus/add",
        type: "POST",
        data: "category=" + value,
        success: function (data) {
          $(".content-recipe").html(data);
          document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
              var row = event.target.closest("tr");
              var destinationTable = event.target.checked ? document.querySelector("#recipe tbody") : document.querySelector(".content-recipe table tbody");
              destinationTable.appendChild(row);
            });
          });
        },
      });
    });
  }
  if (document.querySelector("#form-menu-edit")) {
    var id = $("#id_menu").val();
    $.ajax({
      url: "/admin/menus/edit?id=" + id,
      type: "POST",

      success: function (data) {
        $(".recipe").html(data);
      },
    });
    $("#form-menu-edit .select-category").on("change", function () {
      var value = $(this).val();
      $.ajax({
        url: "/admin/menus/edit?id=" + id + "&category=" + value,
        type: "POST",
        data: "category=" + value,
        success: function (data) {
          $(".content-recipe").html(data);
          document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
              var row = event.target.closest("tr");
              if (event.target.checked) {
                document.querySelector("#recipe tbody").appendChild(row);
              } else {
                if (document.querySelector(".content-recipe table tbody")) {
                  document.querySelector(".content-recipe table tbody").appendChild(row);
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
