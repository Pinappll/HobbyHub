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
        $categories = $categories->findAll();
        foreach ($categories as $category) {
            $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category(), "checked" => ""];
        }
        $config["inputs"]["categories"]["value"] = $formatCategories;
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
                $categories = new Category();
                $categories = $categories->findAll();
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
                var_dump($_REQUEST);
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

        $myView->assign("data", $recipe->getList(["is_deleted" => false], $limit = 100)));

    }
}
