<?php

namespace App\Controllers;

use App\Core\Verificator;
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
                    if($menu->save()){
                        $message = "Votre menu a bien été ajouté";
                        
                    }
                }
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
