<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Recipe\RecipeInsert;
use App\Forms\Recipe\RecipeUpdate;
use App\Models\Category;
use App\Models\Recipe as RecipeModel;
use App\Models\Recipe_category;
use App\Tables\RecipeTable;

class Recipe
{

    public function addRecipe(): void
    {
        $myView = new View("Admin/add-recipe", "back");
        $form = new RecipeInsert();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        $categories = new Category();
        $categories = $categories->findAllBy(["is_deleted" => false], "object");
        if(!$categories){
            $errors[] = "Aucune catégorie n'est disponible";
        }else{
            foreach ($categories as $category) {
                $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category(), "checked" => ""];
            }
        }
        $config["inputs"]["categories"]["value"] = $formatCategories ?? [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_REQUEST["categories"])) {
                $_REQUEST["categories"] = [];
            }
            if($_REQUEST["categories"] == []){
                $errors[] = "Veuillez sélectionner au moins une catégorie";
            }else{
            $verificator = new Verificator();
            if ($verificator->checkForm($config, array_merge($_REQUEST, $_FILES), $errors)) {

                $uploadDir = "dist/assets/uploads/";
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $to = $uploadDir . uniqid() . "-" . $_FILES["inputFileImage"]["name"];
                if (move_uploaded_file($_FILES["inputFileImage"]["tmp_name"], $to)) {
                    $recipe = new RecipeModel();
                    $recipe->setId_user_recipe($_REQUEST["id_user"]);
                    $recipe->setTitle_recipe($_REQUEST["title"]);
                    $recipe->setIngredient_recipe($_REQUEST["ingredients_recipe"]);
                    $recipe->setInstruction_recipe($_REQUEST["instruction_recipe"]);
                    $recipe->setImage_url_recipe($to);
                    $recipe->save();
                    foreach ($_REQUEST["categories"] as $category) {
                        $recipeCategory = new Recipe_category();
                        $recipeCategory->setId_recipe_category($recipe->getId());
                        $recipeCategory->setId_category($category);
                        $recipeCategory->save();
                    }
                    $message = "Recette ajoutée";
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image";
                }
            }}
        }

        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }
    public function editRecipe(): void
    {
        if (!isset($_GET["id_recipe"]) || empty($_GET["id_recipe"])) {
            header("Location: /admin/recipes");
            exit;
        }
        $id = $_GET["id_recipe"];
        if (isset($id) && !empty($id)) {

            $myView = new View("Admin/edit-recipe", "back");
            $form = new RecipeUpdate();
            $config = $form->getConfig(["id_recipe" => $id]);
            $errors = [];
            $message = "";

            $recipe = new RecipeModel();
            $recipe = $recipe->getOneBy(["id" => $id], "object");

            if ($recipe) {
                $categories = new Category();
                $categories = $categories->findAllBy(["is_deleted" => false], "object");
                $recipe_catagories = new Recipe_category();
                $recipe_catagories = $recipe_catagories->findAllBy(["id_recipe_category" => $recipe->getId()]);
                $id_recipe_categories = [];
                foreach ($recipe_catagories as $recipe_catagory) {
                    $id_recipe_categories[] = $recipe_catagory["id_category"];
                }
                foreach ($categories as $category) {
                    if (is_array($id_recipe_categories) && isset($id_recipe_categories) && !empty($id_recipe_categories)) {
                        $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category(), "checked" => in_array($category->getId(), $id_recipe_categories) ? "checked" : ""];
                    } else {
                        $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category(), "checked" => ""];
                    }
                }
                $config["inputs"]["categories"]["value"] = $formatCategories;
                $config["inputs"]["title"]["value"] = $recipe->getTitle_recipe();
                $config["inputs"]["ingredients_recipe"]["value"] = $recipe->getIngredient_recipe();
                $config["inputs"]["instruction_recipe"]["value"] = $recipe->getInstruction_recipe();
                $config["inputs"]["id_user"]["value"] = $recipe->getId_user_recipe();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $verificator = new Verificator();
                if (!isset($_REQUEST["categories"])) {
                    $_REQUEST["categories"] = [];
                }
                if($_REQUEST["categories"] == []){
                    $errors[] = "Veuillez sélectionner au moins une catégorie";
                }else{
                if ($verificator->checkForm($config, array_merge($_REQUEST, $_FILES), $errors)) {
                    if ($_FILES["inputFileImage"]["error"] != 4) {
                        $uploadDir = "dist/assets/uploads/";
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $to = $uploadDir . uniqid() . "-" . $_FILES["inputFileImage"]["name"];
                        if (move_uploaded_file($_FILES["inputFileImage"]["tmp_name"], $to)) {
                            $recipe->setImage_url_recipe($to);
                        } else {
                            $errors[] = "Erreur lors de l'upload de l'image";
                        }
                    }

                    $recipe->setId_user_recipe($_REQUEST["id_user"]);
                    $recipe->setTitle_recipe($_REQUEST["title"]);
                    $recipe->setIngredient_recipe($_REQUEST["ingredients_recipe"]);
                    $recipe->setInstruction_recipe($_REQUEST["instruction_recipe"]);
                    if ($recipe->save()) {

                        $categoriesFromFront = array_map('intval', $_REQUEST["categories"]);
                        $different = array_merge(array_diff($id_recipe_categories, $categoriesFromFront), array_diff($categoriesFromFront, $id_recipe_categories));
                        if (!empty($different)) {
                            foreach ($different as $category) {
                                $recipeCategory = new Recipe_category();
                                $recipeCategory = $recipeCategory->getOneBy(["id_recipe_category" => $id, "id_category" => $category], "object");
                                if ($recipeCategory) {
                                    $recipeCategory->delete();
                                } else {
                                    $recipeCategory = new Recipe_category();
                                    $recipeCategory->setId_recipe_category($id);
                                    $recipeCategory->setId_category($category);
                                    $recipeCategory->save();
                                }
                            }
                        }
                        header("Location: /admin/recipes");
                    }
                }
            }
            }
            $myView->assign("configForm", $config);
            $myView->assign("errorsForm", $errors);
            $myView->assign("message", $message);
        }
    }
    public function deleteRecipe(): void
    {
        $id = $_GET["id"];
        $recipe = new RecipeModel();
        $recipe = $recipe->getOneBy(["id" => $id], "object");
        $recipe->setDeleted(true);
        $recipe->save();
        header("Location: /admin/recipes");
    }

    public function showRecipes(): void
    {
        $table = new RecipeTable();
        $configTable = $table->getConfig();
        $recipe = new RecipeModel();
        $myView = new View("Admin/recipes", "back");
        $myView->assign("configTable", $configTable);
            
        $dataRecipe = $recipe->select("DISTINCT " . $recipe->getNameDb() . "_recipe.*")
        ->join($recipe->getNameDb() . "_recipe_category", $recipe->getNameDb() . "_recipe.id = " . $recipe->getNameDb() . "_recipe_category.id_recipe_category")
        ->join($recipe->getNameDb() . "_category", $recipe->getNameDb() . "_category.id = " . $recipe->getNameDb() . "_recipe_category.id_category")
        ->where($recipe->getNameDb() . "_category.is_deleted = false AND " . $recipe->getNameDb() . "_recipe.is_deleted = false")
        ->execute();
        $myView->assign("data", $dataRecipe);
        $myView->assign("title", "Liste des recettes");
    }

    public function index(): void
{
    // Créer une instance de la vue
    $myView = new View("Recipe/recipes", "front");

    // Configuration de la pagination
    $recipesPerPage = 6; // Nombre de recettes par page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $recipesPerPage;

    // Initialiser le modèle de recette
    $recipeModel = new RecipeModel();

    // Récupérer les recettes avec jointure (similaire à showRecipes)
    $dataRecipe = $recipeModel->select("DISTINCT " . $recipeModel->getNameDb() . "_recipe.*")
        ->join($recipeModel->getNameDb() . "_recipe_category", $recipeModel->getNameDb() . "_recipe.id = " . $recipeModel->getNameDb() . "_recipe_category.id_recipe_category")
        ->join($recipeModel->getNameDb() . "_category", $recipeModel->getNameDb() . "_category.id = " . $recipeModel->getNameDb() . "_recipe_category.id_category")
        ->where($recipeModel->getNameDb() . "_category.is_deleted = false AND " . $recipeModel->getNameDb() . "_recipe.is_deleted = false")
        ->limit($recipesPerPage)
        ->execute();

    // Obtenir le nombre total de recettes pour la pagination
    $totalRecipes = $recipeModel->select("COUNT(DISTINCT " . $recipeModel->getNameDb() . "_recipe.id) as total")
        ->join($recipeModel->getNameDb() . "_recipe_category", $recipeModel->getNameDb() . "_recipe.id = " . $recipeModel->getNameDb() . "_recipe_category.id_recipe_category")
        ->join($recipeModel->getNameDb() . "_category", $recipeModel->getNameDb() . "_category.id = " . $recipeModel->getNameDb() . "_recipe_category.id_category")
        ->where($recipeModel->getNameDb() . "_category.is_deleted = false AND " . $recipeModel->getNameDb() . "_recipe.is_deleted = false")
        ->execute();

    $totalRecipes = $totalRecipes[0]['total'] ?? 0;
    $totalPages = ceil($totalRecipes / $recipesPerPage);

    // Utiliser myView->assign pour transmettre les variables à la vue
    $myView->assign("data", $dataRecipe);
    $myView->assign("currentPage", $currentPage);
    $myView->assign("totalPages", $totalPages);
    $myView->assign("recipesPerPage", $recipesPerPage);
    $myView->assign("title", "Liste des recettes");
}
public function viewRecipe(): void
{
    // Récupérer l'ID de la recette depuis l'URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: /recipes");
        exit;
    }

    $id = (int)$_GET['id'];
    $recipeModel = new RecipeModel();

    // Utilisation de la méthode `getOneBy` pour récupérer une recette spécifique
    $recipe = $recipeModel->getOneBy(['id' => $id, 'is_deleted' => false], 'object');

    if (!$recipe) {
        header("Location: /recipes");
        exit;
    }

    // Charger les catégories associées à la recette
    $categories = (new Recipe_category())->findAllBy(['id_recipe_category' => $id]);

    // Créer une instance de la vue
    $myView = new View("Recipe/single-recipe", "front");

    // Assigner les données à la vue
    $myView->assign("recipe", $recipe);
    $myView->assign("categories", $categories);
    $myView->assign("title", "Détails de la recette: " . $recipe->getTitle_recipe());
}



}
