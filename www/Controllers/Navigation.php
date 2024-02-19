<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Verificator;
use App\Models\Navigation as NavigationModel;
use App\Forms\NavigationInsert;
use App\Forms\NavigationUpdate;
use App\Tables\NavigationTable;

class Navigation
{
    public function addNavigation(): void
    {
        $myView = new View("Admin/add-navigation", "back");
        $form = new NavigationInsert();
        $config = $form->getConfig($data =  [
            "navigations_id" => (new NavigationModel())->getColumns("id"),
            "navigations" => (new NavigationModel())->getColumns("name")
        ]);
        
        
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
            header("Location: /admin/navigation");
            exit;
        }

        $id = $_GET["id_navigation"];
        if (isset($id) && !empty($id)){
           
            $myView = new View("Admin/edit-navigation", "back");
            $form = new NavigationUpdate();
            $config = $form->getConfig(["id_navigation" => $id,"navigations_id" => (new NavigationModel())->getColumns("id"),
            "navigations" => (new NavigationModel())->getColumns("name")]);
            $errors = [];
            $message = "";

            $navigation = new NavigationModel();
            $navigation = $navigation->getOneBy(["id" => $id], "object");
        
            if($navigation){
                $config["inputs"]["name"]["value"] = $navigation->getName();
                $config["inputs"]["link"]["value"] = $navigation->getLink();
                $config["inputs"]["position"]["value"] = $navigation->getPosition();
                $config["inputs"]["parent_id"]["value"] = $navigation->getParent_id() ?? null;
                $config["inputs"]["level"]["value"] = $navigation->getLevel();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $verificator = new Verificator();
                if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                    $navigation->setName($_REQUEST["name"]);
                    $navigation->setLink($_REQUEST["link"]);
                    $navigation->setPosition($_REQUEST["position"]);
                    $navigation->setParent_id($_REQUEST["parent_id"]);
                    $navigation->setLevel($_REQUEST["level"]);
                    if($navigation->save()){
                        header("Location: /admin/navigation");
                    }
                    $message = "Navigation modifiée";
                }
            }
            $myView->assign("configForm", $config);
            $myView->assign("errorsForm", $errors);
            $myView->assign("message", $message);
        }
        
    }

    public function showNavigation(): void
    {
        $table = new NavigationTable();
        $configTable = $table->getConfig();
        $navigation = new NavigationModel();
        $myView = new View("Admin/navigation", "back");
        $myView->assign("configTable", $configTable);
        $myView->assign("data", $navigation->getList());
    }

    public function deleteNavigation(): void
    {
        if (!isset($_GET["id_navigation"]) || empty($_GET["id_navigation"])) {
            header("Location: /admin/navigation");
            exit;
        }
        $navigation = new NavigationModel();
        $navigation->setId($_GET["id_navigation"]);
        $navigation->delete();
        header("Location: /admin/navigation");
        exit;
    }

    
}