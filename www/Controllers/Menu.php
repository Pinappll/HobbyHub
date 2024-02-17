<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\MenuInsert;
use App\Models\Menu as MenuModel;

class Menu
{

    public function addMenu(): void
    {
        $form = new MenuInsert();
        $config = $form->getConfig();
        $error = [];
        $message = "";
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
