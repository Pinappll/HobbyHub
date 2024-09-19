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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    $message = "Recette ajoutée";
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image";
                }
            }
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
                $config["inputs"]["title"]["value"] = $recipe->getTitle_recipe();
                $config["inputs"]["ingredients_recipe"]["value"] = $recipe->getIngredient_recipe();
                $config["inputs"]["instruction_recipe"]["value"] = $recipe->getInstruction_recipe();
                $config["inputs"]["id_user"]["value"] = $recipe->getId_user_recipe();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $verificator = new Verificator();
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
                    header("Location: /admin/recipes");
                    
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

        $myView->assign("data", $recipe->getList(["is_deleted" => false], $limit = 100));
        $myView->assign("title", "Liste des recettes");
    }
    public function searchRecipes(): void
    {
        if (isset($_GET["search_value"])) {
            $recipe = new RecipeModel();
            
            
            if($_GET["search_value"] == ""){
                $data= [];
            }else{
                $data = $recipe->findAllBy(["title_recipe"=>"%".$_GET["search_value"]."%"], "object");
            }
            $myView = new View("Partiel/listeRecipeSearch", null);
            $myView->assign("recipes", $data);
    
            }
        
    }
    public function getRecipe(): void
{
    if (isset($_GET["id"])) {
        $recipeModel = new RecipeModel();
        $recipe = $recipeModel->getOneBy(["id" => $_GET["id"]]);

        if ($recipe) {
            // Filtrer le tableau pour enlever les clés numériques
            $filteredRecipe = array_filter($recipe, function ($key) {
                return !is_numeric($key);
            }, ARRAY_FILTER_USE_KEY);

            echo json_encode([
                'status' => 'success',
                'message' => 'La recette a été récupérée avec succès.',
                'data' => $filteredRecipe // Utiliser le tableau filtré
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Recette non trouvée.'
            ]);
        }
    }
}

}
