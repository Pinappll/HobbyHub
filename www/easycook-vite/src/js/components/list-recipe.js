document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("#form-menu-insert")) {
    document.querySelector("#search_recipe").addEventListener("input", async (e)  => {
      try {
        let response = await fetch('/api/list/recipes?search_value='+e.currentTarget.value, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json' // Précise que le contenu est du JSON
            },
           
        });
        if (!response.ok) {
          throw new Error("Erreur lors de la récupération des recettes");
      }

      // Récupérer le contenu HTML (par exemple des <li>)
      let htmlContent = await response.text();

      // Sélectionner ou créer dynamiquement un élément <ul>
      let existingUl = document.querySelector('#form-menu-insert ul.search-results');
      if (existingUl) {
          existingUl.remove();  // Supprimer l'ancien <ul> pour réinitialiser les résultats
      }

      // Créer un nouvel élément <ul> sous l'input #search_recipe
      let ul = document.createElement('ul');
      ul.classList.add('search-results');
      
      // Insérer le contenu HTML dans le <ul>
      ul.innerHTML = htmlContent;

      // Ajouter le <ul> juste après l'input #search_recipe
      document.querySelector('#search_recipe').parentNode.classList.add('input-search');
      document.querySelector('#search_recipe').parentNode.appendChild(ul);
      document.querySelectorAll('.li-recipe-search').forEach((li) => {
        li.addEventListener('click',async (e) => {
          try{
            const clickedLi = e.currentTarget;
            
            const hiddenInput = clickedLi.querySelector('input[type="hidden"]');
            
            const recipeId = hiddenInput.value;
            e.currentTarget.value;
        // Effectuer la requête POST
          let response = await fetch('/api/recipe?id='+recipeId, {
              method: 'GET',
              headers: {
                  'Content-Type': 'application/json' // Précise que le contenu est du JSON
              },
            
          });
          data = await response.json();
          console.log(data);
          document.querySelector('.search-results').classList.add('hidden');
       
            if (!response.ok) {
              throw new Error("Erreur lors de la récupération des recettes");
            }
            if (data.status === "success") {
              const recipe = data.data; // Récupérer l'objet recette
      
              // Créer une nouvelle ligne <tr>
              const tr = document.createElement('tr');
              tr.classList.add('recipe-row');
              // Colonnes du tableau (td) pour chaque champ de la recette
              tr.innerHTML = `
                  <td>${recipe.id}</td>
                  <td>${recipe.title_recipe}</td>
                  <td>${recipe.ingredient_recipe}</td>
                  <td>${recipe.instruction_recipe}</td>
                  <td><img src="/${recipe.image_url_recipe}" alt="Image recette" style="width: 100px; height: auto;"></td>
              `;
      
              // Ajouter la nouvelle ligne au tableau
              tr.addEventListener('click', async (e) => {

              });
              document.querySelector('#recipe-table tbody').appendChild(tr);
              const xhr = new XMLHttpRequest();
              xhr.open('GET', '/admin/menus/add?recipe_id=1', true);

              // Ajouter l'en-tête pour indiquer que la requête est faite via AJAX
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

              xhr.onload = function() {
                  if (xhr.status >= 200 && xhr.status < 300) {
                      // Réponse réussie
                      console.log('Réponse reçue:', xhr.responseText);
                  } else {
                      console.error('Erreur:', xhr.statusText);
                  }
              };

              xhr.onerror = function() {
                  console.error('Erreur réseau');
              };

              xhr.send();
              
          }
          } catch (error) {
            console.error("Erreur lors du chargement des commentaires :", error);
          }
        });
      });
        
    } catch (error) {
        console.error("Erreur lors du chargement des commentaires :", error);
    }
    });
  }
  if (document.querySelector("#form-menu-edit")){
    document.querySelector("#search_recipe").addEventListener("input", async (e)  => {
      try {
        e.currentTarget.value;
        // Effectuer la requête POST
        let response = await fetch('/api/list/recipes?search_value='+e.currentTarget.value, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json' // Précise que le contenu est du JSON
            },
           
        });
        console.log(response);
        // Vérifier si la réponse est correcte
        let htmlContent = await response.text();
        console.log(htmlContent);
        const commentsList = document.querySelector('#form-menu-edit .content-recipe');
        commentsList.innerHTML = htmlContent;
        
    } catch (error) {
        console.error("Erreur lors du chargement des commentaires :", error);
    }
    });
  }
    
});

