<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Page\PageEdit;
use App\Forms\Page\PageInsert;
use App\Models\Navigation;
use App\Models\Page as PageModel;
use App\Models\Review;
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
        $form = new PageInsert();
        $configForm = $form->getConfig();
        $error = [];
        $message = "";
        $navigation = new Navigation();
        $navigation = $navigation->findAllBy(["id_page" => "0"], "object");
        $formatNav = [];
        foreach ($navigation as $nav) {
            $formatNav[] = ["id" => $nav->getId(), "name" => $nav->getLink()];
        }
        $configForm["inputs"]["select-url"]["option"] = $formatNav;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();
            if ($verificator->checkForm($configForm, $_REQUEST, $error)) {
                $page = new PageModel();
                $page->setTitle_page($_POST['title_page']);
                $page->setContent_page($_POST['content_page']);
                if ($page->save()) {
                    $navigation = new Navigation();
                    $navigation = $navigation->getOneBy(["id" => $_POST['select-url']], "object");
                    $navigation = $navigation->setId_page($page->getId());
                    $navigation->save();
                    header('Location: /admin/pages');
                    exit;
                }
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
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: /admin/pages');
            exit;
        } else {


            $id = $_GET['id'];

            $page = (new PageModel())->getOneBy(['id' => $id], "object");
            $form = new PageEdit();
            $configForm = $form->getConfig();
            $error = [];
            $message = "";
            $navigation = new Navigation();

            $navigation = $navigation->select()->where('id_page = 0')->execute("object");
            $formatNav = [];
            foreach ($navigation as $nav) {
                $formatNav[] = ["id" => $nav->getId(), "name" => $nav->getLink()];
            }
            $navigationLinkToPage = (new Navigation())->getOneBy(["id_page" => $id], "object");
            if ($navigationLinkToPage) {
                $formatNav[] = ["id" => $navigationLinkToPage->getId(), "name" => $navigationLinkToPage->getLink(), "selected" => "selected"];
            }
            $configForm["config"]["action"] = "/admin/pages/edit-page?id=" . $id;
            $configForm["inputs"]["title_page"]["value"] = $page->getTitle_page();
            $configForm["inputs"]["select-url"]["option"] = $formatNav;

            if ($page) {
                $myView = new View("Admin/page-edit", "back");
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $verificator = new Verificator();
                    if ($verificator->checkForm($configForm, $_REQUEST, $error)) {

                        $page->setTitle_page($_POST['title_page']);
                        $page->setContent_page($_POST['content_page']);
                        if ($page->save()) {
                            $navigation = new Navigation();
                            $navigation = $navigation->getOneBy(["id" => $_POST['select-url']], "object");
                            if ($navigation->getId_page() != $page->getId()) {
                                $navigationold = new Navigation();
                                $navigationold = $navigationold->select()->where("id_page = " . $page->getId())->execute("object");
                                if ($navigationold) {
                                    foreach ($navigationold as $nav) {
                                        $nav = $nav->setId_page(0);
                                        $nav->save();
                                    }
                                }
                                $navigation = $navigation->setId_page($page->getId());
                                $navigation->save();
                            }
                        }
                    }
                }
                $myView->assign("configForm", $configForm);
                $myView->assign("errorsForm", $error);
                $myView->assign("title", "Éditer une page");
                $myView->assign("page", $page);
            } else {

                header('Location: /admin/pages');
                exit;
            }
        }
    }

    public function deletePage(): void
    {
        if (!isset($_GET["id"]) || empty($_GET["id"])) {
            header("Location: /admin/pages");
            exit;
        }
        $page = new PageModel();
        $page = $page->getOneBy(["id" => $_GET["id"]], "object");
        $page->delete();

        $navigation = new Navigation();
        $navigation = $navigation->getOneBy(["id_page" => $_GET["id"]], "object");
        if ($navigation) {
            $navigation = $navigation->setId_page(0);
            $navigation->save();
        }

        header("Location: /admin/pages");
        exit;
    }
    public function readPage(int $id): void
    {
        $page = (new PageModel())->getOneBy(['id' => $id], "object");
        $myView = new View("Main/page", "front");
        // $contenuJson = '{"html": "<p>Ceci est du contenu HTML récupéré depuis la base de données.</p>"}';
        $myView->assign("page", json_decode($page->getContent_page()));
        $myView->assign("idPage",json_decode($page->getId()));
    }
}
