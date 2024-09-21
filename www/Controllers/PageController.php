<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\Page\PageEdit;
use App\Forms\Page\PageInsert;
use App\Models\Navigation;
use App\Models\Page as PageModel;
use App\Models\Review;
use App\Tables\PageTable;
use Exception;

class PageController
{


    public function showPages(): void
    {
        $table = new PageTable();
        $configTable = $table->getConfig();
        $category = new PageModel();
        $categories = $category->findAllBy(["is_deleted" => false] );
        $myView = new View("Admin/pages", "back");
        $myView->assign("data", $categories);
        $myView->assign("configTable", $configTable);
        $myView->assign("title", "Liste des pages");
    }

    public function addPage(): void
    {
        $form = new PageInsert();
        $configForm = $form->getConfig();
        $navigation = new Navigation();
        $navigations = $navigation->findAllBy(["id_page" => 0], "object");
        $optionsNavigations = [];
        if($navigations){
            
            foreach ($navigations as $nav) {
                
                $optionsNavigations[] = ["id" => $nav->getId(), "name" => $nav->getName()];
            }
        }
        
        $configForm["inputs"]["select_navigation"]["option"] = $optionsNavigations;
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();
            if ($verificator->checkForm($configForm, $_REQUEST, $error)) {
                $pdo = DB::getPDO();
                // try {
                    $pdo->beginTransaction();
                    $page = new PageModel();
                    $page->setTitle_page($_POST['title_page']);
                    $page->setContent_page($_POST['content_page']);
                    if (!$page->save()) {
                        throw new Exception("Échec de l'insertion de la page");
                    }
                    
                    $navigation = new Navigation();
                    $navigation  = $navigation->populate($_REQUEST["select_navigation"]);
                    var_dump($navigation);
                    
                    if($navigation){
                        $navigation ->setIdPage($page->getId());
                    }
                    
                    // Sauvegarde de la mise à jour de la navigation

                    if (!$navigation->save()) {
                        
                        throw new Exception("Échec de la mise à jour de la navigation");
                    }
    
                    // Validation de la transaction
                    $pdo->commit();
    
                    // Redirection en cas de succès
                    header('Location: /admin/pages');
                    exit;

                // } catch (\Exception $e) {
                //     $pdo->rollBack();
                //     $error[] ="dadadhzjbada". $e->getMessage();
                    
                // }

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

        $navigation = new Navigation();
        $navigations = $navigation->findAllBy(["id_page" => 0], "object");
        $navigationSelect = $navigation->getOneBy(["id_page" => $id], "object");

        $optionsNavigations = [];
        foreach ($navigations as $nav) {
            $optionsNavigations[] = ["id" => $nav->getId(), "name" => $nav->getName()];
        }

        if ($navigationSelect) {
            $optionsNavigations[] = [
                "id" => $navigationSelect->getId(),
                "name" => $navigationSelect->getName(),
                "selected" => true
            ];
        }
        $form = new PageEdit();
        $configForm = $form->getConfig(["page" => $page]);
        $configForm["inputs"]["name"]["update"] = true;
        $configForm["inputs"]["name"]["option"] = $optionsNavigations ?? [];
        $error = [];
        $message = "";

        if ($page) {
            $myView = new View("Admin/page-edit", "back");
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $verificator = new Verificator();
                if ($verificator->checkForm($configForm, $_REQUEST, $error)) {
                    $pdo = DB::getPDO();
                    try {
                        $pdo->beginTransaction();

                        // Mise à jour des informations de la page
                        $page->setTitle_page($_POST['title_page']);
                        $page->setContent_page($_POST['content_page']);

                        // Vérification de la navigation
                        $newNavigationId = $_POST['name'] ?? null; // Remplacez par le bon champ de votre formulaire
                        if ($navigationSelect && $newNavigationId !== $navigationSelect->getId()) {
                            // Supprimer l'ancienne navigation
                            $navigationSelect->setIdPage(0); // Enlève l'association
                            $navigationSelect->save();
                        }

                        // Si une nouvelle navigation est sélectionnée
                        if ($newNavigationId) {
                            $newNavigation = (new Navigation())->getOneBy(['id' => $newNavigationId], "object");
                            if ($newNavigation) {
                                $newNavigation->setIdPage($page->getId()); // Associer la nouvelle navigation à la page
                                $newNavigation->save();
                            }
                        }

                        // Enregistrer la page
                        $page->save();
                        $pdo->commit();
                        header('Location: /admin/pages');
                        exit;
                    } catch (\Exception $e) {
                        $pdo->rollBack();
                        $error[] = $e->getMessage();
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
        if ($page) {
            $pdo = DB::getPDO();
                try {
                    $pdo->beginTransaction();
                    
                    $page->setIs_deleted(true);
                    if (!$page->save()) {
                        throw new Exception("Échec supression de la page");
                    }
                    $navigation = new Navigation();
                    $navigation = $navigation->getOneBy(["id_page" => $_GET["id"]], "object");
                    if($navigation){
                        $navigation->setIs_deleted(true);

                    }
                    $review = new Review();
                    $review = $review->findAllBy(["id_page_review" => $_GET["id"]], "object");
                    
                    if($review){
                        foreach ($review as $review) {
                            $review->setIs_deleted(true);
                            if (!$review->save()) {
                                throw new Exception("Échec de la suppression des reviews");
                            }
                        }
                    }
                    
                    
                    // Validation de la transaction
                    $pdo->commit();
    
                    // Redirection en cas de succès
                    header('Location: /admin/pages');
                    exit;

                } catch (\Exception $e) {
                    $pdo->rollBack();
                    $error[] = $e->getMessage();
                    
                }
        }
        
    
        // Redirection vers la liste des pages après la suppression
        header("Location: /admin/pages");
        exit;

    }
    public function readPage(int $id): void
    {
        $page = (new PageModel())->getOneBy(['id' => $id], "object");
        $myView = new View("Main/page", "front");
        // $contenuJson = '{"html": "<p>Ceci est du contenu HTML récupéré depuis la base de données.</p>"}';
        $styles = '';

        $styles = '';

        foreach (json_decode($page->getContent_page())->styles as $style) {
            // Vérifiez si les sélecteurs sont un tableau d'objets ou de chaînes
            if (isset($style->selectors) && is_array($style->selectors)) {
                // Si ce sont des objets, récupérez le nom avec un point devant
                $selectors = implode(', ', array_map(function($s) {
                    return isset($s->name) ? '.' . $s->name : ''; // Ajoutez un point
                }, $style->selectors));
            } elseif (isset($style->selectors) && is_string($style->selectors)) {
                // Si c'est une chaîne, ajoutez un point si c'est une classe
                $selectors = '.' . $style->selectors;
            } else {
                continue; // Si selectors est absent, passer à l'itération suivante
            }

            // Nettoyez les sélecteurs pour éviter les chaînes vides
            $selectors = trim($selectors);
            if (empty($selectors)) {
                continue; // Passer si aucun sélecteur valide
            }

            $styleContent = '';
            foreach ($style->style as $property => $value) {
                $styleContent .= "{$property}: {$value}; ";
            }

            // Ajout de la règle CSS
            $styles .= "{$selectors} { {$styleContent} } ";

            // Gérer les styles media
            if (isset($style->mediaText)) {
                $styles .= "@media {$style->mediaText} { {$selectors} { {$styleContent} } } ";
            }
        }
        $myView->assign("page", json_decode($page->getContent_page()));
        $myView->assign("styles", $styles);
        $myView->assign("idPage",json_decode($page->getId()));
    }
}
