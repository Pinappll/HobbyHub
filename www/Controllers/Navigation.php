<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Verificator;
use App\Models\Navigation as NavigationModel;
use App\Forms\NavigationInsert;

class Navigation
{
    public function addNavigation(): void
    {
        $myView = new View("Admin/add-navigation", "back");
        $form = new NavigationInsert();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $navigation = new NavigationModel();
                $navigation->setName($_REQUEST["name"]);
                $navigation->setLink($_REQUEST["link"]);
                $navigation->setPosition($_REQUEST["position"]);
                $navigation->setParent_id($_REQUEST["parent_id"]);
                $navigation->setLevel($_REQUEST["level"]);
                
                $navigation->save();
                $message = "Navigation ajoutée";
            }
        }
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    
    public function editNavigation(): void
    {
        if (!isset($_GET["id_navigation"]) || empty($_GET["id_navigation"])) {
            header("Location: /admin/navigations");
            exit;
        }
        $myView = new View("Admin/edit-navigation", "back");
        $form = new NavigationUpdate();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        $navigation = new NavigationModel();
        $navigation->setId($_GET["id_navigation"]);
        $navigation->read();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $navigation->setName($_REQUEST["name"]);
                $navigation->setLink($_REQUEST["link"]);
                $navigation->setPosition($_REQUEST["position"]);
                $navigation->setParent_id($_REQUEST["parent_id"]);
                $navigation->setLevel($_REQUEST["level"]);
                $navigation->update();
                $message = "Navigation modifiée";
            }
        }
        $config["config"]["action"] = "/admin/navigation/edit?id_navigation=" . $_GET["id_navigation"];
        $config["config"]["submit"] = "modifier";
        $config["inputs"]["name"]["value"] = $navigation->getName();
        $config["inputs"]["link"]["value"] = $navigation->getLink();
        $config["inputs"]["position"]["value"] = $navigation->getPosition();
        $config["inputs"]["parent_id"]["value"] = $navigation->getParent_id();
        $config["inputs"]["level"]["value"] = $navigation->getLevel();
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    public function deleteNavigation(): void
    {
        if (!isset($_GET["id_navigation"]) || empty($_GET["id_navigation"])) {
            header("Location: /admin/navigations");
            exit;
        }
        $navigation = new NavigationModel();
        $navigation->setId($_GET["id_navigation"]);
        $navigation->delete();
        header("Location: /admin/navigations");
        exit;
    }
}