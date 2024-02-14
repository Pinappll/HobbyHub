<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\RecipeInsert;
use App\Models\Recipe as RecipeModel;

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
            var_dump($_FILES);
            if ($verificator->checkForm($config, array_merge($_REQUEST, $_FILES), $errors)) {

                $uploadDir = "uploads/";
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
    public function readRecipe(): void
    {
        $myView = new View("Recipe/readRecipe", "front");
    }
    public function updateRecipe(): void
    {
        $myView = new View("Recipe/updateRecipe", "front");
    }
    public function deleteRecipe(): void
    {
        $myView = new View("Recipe/deleteRecipe", "front");
    }
    public function recipes(): void
    {
        $myView = new View("Recipe/recipes", "front");
    }
    public function singleRecipe(): void
    {
        $myView = new View("Recipe/single-recipe", "front");
    }
    public function showRecipes(): void
    {
        $myView = new View("Admin/recipes", "back");
    }
}
