<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Menu\MenuInsert;
use App\Forms\Menu\MenuEdit;
use App\Models\Category;
use App\Models\Menu as MenuModel;
use App\Models\Recipe;
use App\Models\Recipe_category;
use App\Models\Recipe_menu;
use App\Tables\MenuTable;

class Menu
{
    public function addMenu(): void
    {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $category = $_POST["category"];
            $recipe = new Recipe();


            // Récupérer les recettes envoyées depuis le front-end (selectedRecipes)
            $selectedRecipes = isset($_POST["selectedRecipes"]) ? $_POST["selectedRecipes"] : [];

            $queryParams = [':category' => $category];

            // Construire la condition de base avec la catégorie et la suppression logique
            $whereCondition = $recipe->getNameDb() . "_recipe_category.id_category = :category AND " . $recipe->getNameDb() . "_recipe.is_deleted = false";

            // Exclure les recettes déjà présentes dans `selectedRecipes` (les recettes sélectionnées par l'utilisateur)
            if (!empty($selectedRecipes)) {
                // Générer une liste de paramètres nommés pour la clause IN
                $placeholders = [];
                foreach ($selectedRecipes as $index => $recipeId) {
                    $paramName = ":recipe_id_" . $index;
                    $placeholders[] = $paramName;
                    $queryParams[$paramName] = $recipeId; // Ajouter le paramètre avec le nom généré
                }
                $placeholdersStr = implode(',', $placeholders);

                // Ajouter la condition NOT IN au whereCondition
                $whereCondition .= " AND " . $recipe->getNameDb() . "_recipe.id NOT IN ($placeholdersStr)";
            }

            // Appliquer la clause WHERE une seule fois
            $recipes =  $recipe->select($recipe->getNameDb()."_recipe.* ")
                ->join($recipe->getNameDb() . "_recipe_category", $recipe->getNameDb() . "_recipe.id = " . $recipe->getNameDb() . "_recipe_category.id_recipe_category")
                ->where($whereCondition)
                ->executeWithParams($queryParams);

            // Passer les recettes à la vue
            $myView = new View("Partiel/listeRecipeSearch", null);
            $recipes_categories_id = [];
            $recipe_category = new Recipe_category();
            foreach ($recipes as $recipe) {
                // Récupérer les catégories pour la recette
                $categories = $recipe_category->select($recipe_category->getNameDb() . "_recipe_category.id_category")
                    ->where($recipe_category->getNameDb() . "_recipe_category.id_recipe_category = :id")
                    ->executeWithParams([":id" => $recipe["id"]]);
                
                // Filtrer pour ne garder que 'id_category'
                $filteredCategories = [];
                foreach ($categories as $category) {
                    $filteredCategories[] = ["id_category" => $category["id_category"]];
                }
            
                // Assigner les catégories filtrées à la recette
                $recipes_categories_id[$recipe["id"]] = ["category-ids" => $filteredCategories];
            }
            
            $myView->assign("recipes", $recipes);
            $myView->assign("recipes_categories_id", $recipes_categories_id);
        } else {
            $form = new MenuInsert();
            $config = $form->getConfig();
            $error = [];
            $message = "";
            $categories = new Category();
            $categories = $categories->findAllBy(["is_deleted" => false], "object");
            $formatCategories = [];
            foreach ($categories as $category) {
                $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category()];
            }
            $config["inputs"]["select_recipe"]["option"] = $formatCategories;
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (!isset($_REQUEST["recipe"])) {
                    $_REQUEST["recipe"] = [];
                }
                if (!isset($_REQUEST["select_recipe"])) {
                    $_REQUEST["select_recipe"] = [];
                }
                $verificator = new Verificator();
                if ($verificator->checkForm($config, $_REQUEST, $error)) {
                    $menu = new MenuModel();
                    $menu->setTitle_menu($_POST["title"]);
                    $menu->setDescription_menu($_POST["description"]);

                    if ($menu->save()) {
                        $message = "Votre menu a bien été ajouté";
                        $recipe_menu = new Recipe_menu();
                        $recipe_menu->setId_menu($menu->getId());
                        foreach ($_POST["recipe"] as $recipe) {
                            $recipe_menu->setId(null);
                            $recipe_menu->setId_recipe($recipe);
                            $recipe_menu->save();
                        }
                    }
                }
            }
            $myView = new View("admin/menu/add-menu", "back");
            $myView->assign("configForm", $config);
            $myView->assign("errorsForm", $error);
            $myView->assign("message", $message);
        }
    }
    public function updateMenu(): void
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        if (!isset($_POST["category"])) {
            $recipe = new Recipe();
            $id = $_GET["id"]; // Valider cette valeur au besoin

            // Récupérer les recettes du menu
            $recipes = $recipe->select("DISTINCT " .$recipe->getNameDb()."_recipe.*")
                ->join($recipe->getNameDb() . "_recipe_menu", $recipe->getNameDb() . "_recipe.id = " . $recipe->getNameDb() . "_recipe_menu.id_recipe")
                ->join($recipe->getNameDb() . "_recipe_category", $recipe->getNameDb() . "_recipe.id = " . $recipe->getNameDb() . "_recipe_category.id_recipe_category")
                ->where($recipe->getNameDb() . "_recipe_menu.id_menu = :id")
                ->executeWithParams([':id' => $id]);

            // Passer les données à la vue
            $myView = new View("Partiel/listeRecipMenu", null);
            $myView->assign("recipes", $recipes);
            $recipes_categories_id = [];
            $recipe_category = new Recipe_category();
            foreach ($recipes as $recipe) {
                // Récupérer les catégories pour la recette
                $categories = $recipe_category->select($recipe_category->getNameDb() . "_recipe_category.id_category")
                    ->where($recipe_category->getNameDb() . "_recipe_category.id_recipe_category = :id")
                    ->executeWithParams([":id" => $recipe["id"]]);
                
                // Filtrer pour ne garder que 'id_category'
                $filteredCategories = [];
                foreach ($categories as $category) {
                    $filteredCategories[] = ["id_category" => $category["id_category"]];
                }
            
                // Assigner les catégories filtrées à la recette
                $recipes_categories_id[$recipe["id"]] = ["category-ids" => $filteredCategories];
            }
            $myView->assign("recipes_categories_id", $recipes_categories_id);
        } else {
            $category = $_POST["category"];
            $recipe = new Recipe();

            // Récupérer les recettes envoyées depuis le front-end (selectedRecipes)
            $selectedRecipes = isset($_POST["selectedRecipes"]) ? $_POST["selectedRecipes"] : [];

            $queryParams = [':category' => $category];

            // Construire la condition de base avec la catégorie et la suppression logique
            $whereCondition = $recipe->getNameDb() . "_recipe_category.id_category = :category AND " . $recipe->getNameDb() . "_recipe.is_deleted = false";

            // Exclure les recettes déjà présentes dans `selectedRecipes` (les recettes sélectionnées par l'utilisateur)
            if (!empty($selectedRecipes)) {
                // Générer une liste de paramètres nommés pour la clause IN
                $placeholders = [];
                foreach ($selectedRecipes as $index => $recipeId) {
                    $paramName = ":recipe_id_" . $index;
                    $placeholders[] = $paramName;
                    $queryParams[$paramName] = $recipeId; // Ajouter le paramètre avec le nom généré
                }
                $placeholdersStr = implode(',', $placeholders);

                // Ajouter la condition NOT IN au whereCondition
                $whereCondition .= " AND " . $recipe->getNameDb() . "_recipe.id NOT IN ($placeholdersStr)";
            }

            // Appliquer la clause WHERE une seule fois
            $recipes =  $recipe->select($recipe->getNameDb()."_recipe.*, ". $_POST["category"] ." as category")
                ->join($recipe->getNameDb() . "_recipe_category", $recipe->getNameDb() . "_recipe.id = " . $recipe->getNameDb() . "_recipe_category.id_recipe_category")
                ->where($whereCondition)
                ->executeWithParams($queryParams);

            // Passer les recettes à la vue
            $myView = new View("Partiel/listeRecipeSearch", null);
            $myView->assign("recipes", $recipes);
            $recipes_categories_id = [];
            $recipe_category = new Recipe_category();
            foreach ($recipes as $recipe) {
                // Récupérer les catégories pour la recette
                $categories = $recipe_category->select($recipe_category->getNameDb() . "_recipe_category.id_category")
                    ->where($recipe_category->getNameDb() . "_recipe_category.id_recipe_category = :id")
                    ->executeWithParams([":id" => $recipe["id"]]);
                
                // Filtrer pour ne garder que 'id_category'
                $filteredCategories = [];
                foreach ($categories as $category) {
                    $filteredCategories[] = ["id_category" => $category["id_category"]];
                }
            
                // Assigner les catégories filtrées à la recette
                $recipes_categories_id[$recipe["id"]] = ["category-ids" => $filteredCategories];
            }
            $myView->assign("recipes_categories_id", $recipes_categories_id);
        }
    } else {
        if (!isset($_GET["id"])) {
            header("Location: /admin/menus");
        } else {
            $id = $_GET["id"];
            $menu = new MenuModel();
            $menu = $menu->getOneBy(["id" => $id], "object");

            if (!$menu) {
                $customError = new Error();
                $customError->page404();
            } else {
                $form = new MenuEdit();
                $config = $form->getConfig(["id" => $id, "title" => $menu->getTitle_menu(), "description" => $menu->getDescription_menu()]);
                $error = [];
                $message = "";

                // Récupérer toutes les catégories disponibles
                $categories = new Category();
                $categories = $categories->findAllBy(["is_deleted" => false], "object");
                $formatCategories = [];
                foreach ($categories as $category) {
                    $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category()];
                }
                $config["inputs"]["select_recipe"]["option"] = $formatCategories;

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if (!isset($_REQUEST["recipe"])) {
                        $_REQUEST["recipe"] = [];
                    }
                    if (!isset($_REQUEST["select_recipe"])) {
                        $_REQUEST["select_recipe"] = $config["inputs"]["select_recipe"]["option"] = $formatCategories;;
                    }
                    $verificator = new Verificator();
                    if ($verificator->checkForm($config, $_REQUEST, $error)) {
                        $menu->setTitle_menu($_POST["title"]);
                        $menu->setDescription_menu($_POST["description"]);

                        if ($menu->save()) {
                            $message = "Votre menu a bien été modifié";

                            // Gérer les associations recettes/menus
                            $recipe_menu = new Recipe_menu();
                            $existingRecipes = $recipe_menu->findAllBy(["id_menu" => $menu->getId()], "object");

                            $id_recipe_menu = array_map(fn($rm) => $rm->getId_recipe(), $existingRecipes);
                            $recipesFromFront = array_map('intval', $_REQUEST["recipe"]);

                            // Trouver les différences entre l'interface utilisateur et la base de données
                            $different = array_merge(array_diff($id_recipe_menu, $recipesFromFront), array_diff($recipesFromFront, $id_recipe_menu));

                            // Supprimer les associations
                            foreach ($different as $diff) {
                                $recipe_menu = new Recipe_menu();
                                $recipe_menu = $recipe_menu->getOneBy(["id_menu" => $menu->getId(), "id_recipe" => $diff], "object");
                                if ($recipe_menu) {
                                    $recipe_menu->delete();
                                }
                            }

                            // Ajouter les nouvelles associations
                            foreach ($_POST["recipe"] as $recipe) {
                                $recipe_menu = new Recipe_menu();
                                $recipe_menu = $recipe_menu->getOneBy(["id_menu" => $menu->getId(), "id_recipe" => $recipe], "object");
                                if (!$recipe_menu) {
                                    $recipe_menu = new Recipe_menu();
                                    $recipe_menu->setId_menu($menu->getId());
                                    $recipe_menu->setId_recipe($recipe);
                                    $recipe_menu->save();
                                }
                            }

                            header("Location: /admin/menus");
                        }
                    }
                }

                $myView = new View("Admin/Menu/edit-menu", "back");
                $myView->assign("configForm", $config);
                $myView->assign("errorsForm", $error);
                $myView->assign("message", $message);
            }
        }
    }
}



    public function deleteMenu(): void
    {
        if (isset($_GET["id"])) {
            $menu = new MenuModel();
            $menu = $menu->getOneBy(['id' => $_GET["id"]], "object");
            if ($menu) {
                $menu->setIs_deleted(true);
                $menu->save();
            }
        }
        header("Location: /admin/menus");
    }
    public function showMenus(): void
    {
        $menu = new MenuModel();
        $data = $menu->getList(["is_deleted" => false]);
        $table = new MenuTable();
        $configTable = $table->getConfig();
        $myView = new View("Admin/Menu/list-menu", "back");
        $myView->assign("configTable", $configTable);
        $myView->assign("data", $data);
        $myView->assign("title", "Liste des menus");
    }
}
