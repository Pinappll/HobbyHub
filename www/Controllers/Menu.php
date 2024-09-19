<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Menu\MenuInsert;
use App\Forms\Menu\MenuEdit;
use App\Models\Menu as MenuModel;
use App\Models\Recipe;
use App\Controllers\Recipe as RecipeController;
use App\Models\Recipe_category;
use App\Models\Recipe_menu;
use App\Tables\MenuTable;

class Menu
{
    private array $ids_recipe = [];
    public function addMenu(): void
    {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if(isset($_GET["search_value"])){
                $recipe = new RecipeController();
                $recipe->searchRecipes($_GET["search_value"]);
            } 
        } else {
            $form = new MenuInsert();
            $config = $form->getConfig();
            $error = [];
            $message = "";
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (!isset($_REQUEST["search_recipe"])) {
                    $_REQUEST["search_recipe"] = [];
                }
                if (!isset($_REQUEST["recipe"])) {
                    $_REQUEST["recipe"] = [];
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
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        if (!isset($_REQUEST["recipe"])) {
                            $_REQUEST["recipe"] = [];
                        }
                        if (!isset($_REQUEST["select_recipe"])) {
                            $_REQUEST["select_recipe"] = [];
                        }
                        $verificator = new Verificator();
                        if ($verificator->checkForm($config, $_REQUEST, $error)) {
                            $menu->setTitle_menu($_POST["title"]);
                            $menu->setDescription_menu($_POST["description"]);
                            if ($menu->save()) {
                                $message = "Votre menu a bien été modifié";
                                $recipe_menu = new Recipe_menu();
                                $recipe_menu = $recipe_menu->findAllBy(["id_menu" => $menu->getId()], "object");
                                $id_recipe_menu = [];
                                foreach ($recipe_menu as $recipe) {
                                    $id_recipe_menu[] = $recipe->getId_recipe();
                                }
                                $recipesFromFront = array_map('intval', $_REQUEST["recipe"]);

                                $different = array_merge(array_diff($id_recipe_menu, $recipesFromFront), array_diff($recipesFromFront, $id_recipe_menu));
                                foreach ($different as $diff) {
                                    $recipe_menu = new Recipe_menu();
                                    $recipe_menu = $recipe_menu->getOneBy(["id_menu" => $menu->getId(), "id_recipe" => $diff], "object");
                                    if ($recipe_menu) {
                                        $recipe_menu->delete();
                                    }
                                }
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
                    //$recipe_menu = new Recipe_menu();
                    //$recipes = $recipe_menu->getRecipeByIdMenu($menu->getId());
                    // $config["inputs"]["recipe"]["value"] = $recipes;
                    $myView = new View("Admin/Menu/edit-menu", "back");
                    $myView->assign("configForm", $config);
                    $myView->assign("errorsForm", $error);
                    $myView->assign("message", $message);
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
