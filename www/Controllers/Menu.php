<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\Menu\MenuInsert;
use App\Models\Category;
use App\Models\Menu as MenuModel;
use App\Models\Recipe;

class Menu
{

    public function addMenu(): void
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $recipe = new Recipe();
            $recipes = $recipe->getRecipeByIdCategory($_POST["category"]);
            $myView = new View("Partiel/listeRecipe", null);
            var_dump($recipes);
            $myView->assign("recipes", $recipes);
        } else {
            $form = new MenuInsert();
            $config = $form->getConfig();
            $error = [];
            $message = "";
            $categories = new Category();
            $categories = $categories->findAll();
            foreach ($categories as $category) {
                $formatCategories[] = ["id" => $category->getId(), "name" => $category->getName_category()];
            }
            $config["options"]["recipe"] = $formatCategories;

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // $title = $_POST["title"];
                // $description = $_POST["description"];
                // if (strlen($title) < 2) {
                //     $error["title"] = "Votre titre doit faire plus de 2 caractères";
                // }
                // if (strlen($description) < 2) {
                //     $error["description"] = "Votre description doit faire plus de 2 caractères";
                // }
                // if (empty($error)) {
                //     $menuModel = new MenuModel();
                //     $menuModel->setTitle($title);
                //     $menuModel->setDescription($description);
                //     $menuModel->insert();
                //     $message = "Votre menu a bien été ajouté";
                // }
            }
            $myView = new View("admin/menu/add-menu", "back");
            $myView->assign("configForm", $config);
            $myView->assign("errorsForm", $error);
            $myView->assign("message", $message);
        }
    }
    public function readMenu(): void
    {
        $myView = new View("Menu/readMenu", "front");
    }
    public function updateMenu(): void
    {
        $myView = new View("Menu/updateMenu", "front");
    }
    public function deleteMenu(): void
    {
        $myView = new View("Menu/deleteMenu", "front");
    }
    public function showMenus(): void
    {
        $myView = new View("Admin/menus", "back");
    }
}
