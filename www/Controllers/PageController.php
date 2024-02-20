<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Page\formPage;
use App\Models\Navigation;
use App\Models\Page as PageModel;
use App\Tables\PageTable;


class PageController
{


    public function showPages(): void
    {
        $table = new PageTable();
        $configTable = $table->getConfig();
        $category = new PageModel();
        $categories = $category->getList();
        $myView = new View("Admin/pages", "back");
        $myView->assign("data", $categories);
        $myView->assign("configTable", $configTable);
    }

    public function addPage(): void
    {
        // Initialisez $pageId avec null ou une valeur par défaut
        $form = new formPage();
        $configForm = $form->getConfig();
        $error = [];
        $message = "";
        $navigation = new Navigation();
        $navigation = $navigation->findAllBy(["id_page" => "0"], "object");
        $formatNav = [];
        foreach ($navigation as $nav) {
            $formatNav[] = ["id" => $nav->getId(), "name" => $nav->getName()];
        }
        $configForm["inputs"]["select-url"]["option"] = $formatNav;
        echo "<pre>";
        var_dump($configForm["inputs"]);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Utilisez isset() pour vérifier si 'id' existe dans $_POST
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $pageId = $_POST['id'];
                $page = (new PageModel())->getOneBy(['id' => $pageId], "object");
                if (!$page) {
                    // Gérez le cas où la page n'est pas trouvée
                    error_log('Page non trouvée');
                    return;
                }
            } else {
                $page = new PageModel();
            }

            $page->setTitle_page($_POST['title_page'] ?? '');
            $page->setContent_page($_POST['content_page'] ?? '');

            if ($page->save()) {
                header('Location: /admin/pages');
                exit;
            } else {
                error_log('Erreur lors de la sauvegarde de la page');
            }
        }

        $myView = new View("Admin/page-add", "back");
        $myView->assign("title", isset($pageId) ? "Modifier une page" : "Ajouter une page");
        $myView->assign("description", isset($pageId) ? "Modifier une page sur le site" : "Ajouter une page au site");
        $myView->assign("configForm", $configForm);
        $myView->assign("errorsForm", $error);
    }

    public function editPage(): void
    {
        $id = (int)$_GET['id'];

        $page = (new PageModel())->getOneBy(['id' => $id], "object");


        if ($page) {
            $myView = new View("Admin/page-edit", "back");
            $myView->assign("title", "Éditer une page");
            $myView->assign("page", $page);
        } else {

            header('Location: /admin/pages');
            exit;
        }
    }

    public function deletePage(): void
    {
        if (!isset($_GET["id"]) || empty($_GET["id"])) {
            header("Location: /admin/pages");
            exit;
        }
        $page = new PageModel();
        $page->setId($_GET["id"]);

        $page->delete();

        header("Location: /admin/pages");
        exit;
    }
}
