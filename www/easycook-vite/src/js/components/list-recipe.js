document.addEventListener("DOMContentLoaded", () => {
  function addCheckboxEventListeners() {
    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
      checkbox.addEventListener("change", (event) => {
        var row = event.target.closest("tr");
        var categories = $(row).find('.hidden').data('categorie-id'); // Récupère les catégories
        var selectedCategory = parseInt($(".select-category").val(), 10); // Convertir en nombre

        if (!event.target.checked) {
          // Si décoché, vérifier si la catégorie sélectionnée est dans les catégories
          if (categories.includes(selectedCategory)) {
            // Déplacer la ligne vers le tableau de contenu
            document.querySelector(".content-recipe table tbody").appendChild(row);
          } else {
            // Sinon, supprimer la ligne
            row.remove();
          }
        } else {
          // Si coché, ajouter la ligne au tableau principal
          document.querySelector("#recipe tbody").appendChild(row);
        }
      });
    });
  }
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

    // Fonction pour ajouter les écouteurs d'événements sur les checkboxes
    

    // Appel initial pour ajouter les écouteurs d'événements aux checkboxes au chargement de la page
    addCheckboxEventListeners();

    // Gestion du changement de catégorie
    $("#form-menu-insert .select-category").on("change", function () {
      var checkedValues = $('input[name="recipe[]"]:checked').map(function () {
        return this.value;
      }).get(); // `.get()` convertit l'objet jQuery en tableau normal
      var value = $(this).val();
      
      $.ajax({
        url: "/admin/menus/add",
        type: "POST",
        data: {
          category: value,
          selectedRecipes: checkedValues // Envoyer toutes les recettes sélectionnées
        },
        success: function (data) {
          $(".content-recipe").html(data);

          // Ré-attacher les événements sur les checkboxes après mise à jour du contenu
          addCheckboxEventListeners();
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
        addCheckboxEventListeners(); // Attacher les événements sur les checkboxes après la mise à jour
      },
    });

    // Gestion du changement de catégorie
    $("#form-menu-edit .select-category").on("change", function () {
      var value = $(this).val();

      // Récupérer toutes les valeurs des checkboxes cochés
      var checkedValues = $('input[name="recipe[]"]:checked').map(function () {
        return this.value;
      }).get(); // `.get()` convertit l'objet jQuery en tableau normal

      $.ajax({
        url: "/admin/menus/edit?id=" + id + "&category=" + value,
        type: "POST",
        data: {
          category: value,
          selectedRecipes: checkedValues // Envoyer toutes les recettes sélectionnées
        },
        success: function (data) {
          $(".content-recipe").html(data);
          addCheckboxEventListeners(); // Ré-attacher les événements après mise à jour
        },
      });
    });
  }
});
