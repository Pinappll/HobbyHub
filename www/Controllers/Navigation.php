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
    
    /**
     * Méthode pour ajouter une navigation
     */
    public function addNavigation(): void
    {
        $myView = new View("Admin/add-navigation", "back");
        $form = new NavigationInsert();

        $navigationModel = new NavigationModel();
        $parents = $navigationModel->getParentNavigations(); // Récupérer les parents
        $nextPosition = $navigationModel->getNextPosition(); // Prochaine position
        $positionsInNavbar = $navigationModel->getNavbarPositions(); // Positions des éléments dans la navbar
        $config = $form->getConfig([
            "parents" => $parents,
            "nextPosition" => $nextPosition,
            "positionsInNavbar" => $positionsInNavbar,
            "is_in_navbar" => 1, // Valeur par défaut pour afficher dans la navbar
        ]);

        $errors = [];
        $message = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();

            if ($verificator->checkForm($config, $_POST, $errors)) {
                try {
                    $name = htmlspecialchars($_POST["name"]);
                    $link = $this->slugify($name);
                    $isInNavbar = intval($_POST["is_in_navbar"]);
                    $selectedPosition = intval($_POST["position"]);

                    // Si la position est déjà prise, on la déplace
                    $existingPositions = $navigationModel->getNavbarPositions();
                    if (in_array($selectedPosition, $existingPositions)) {
                        $navigationModel->updatePosition($selectedPosition, $nextPosition);
                    }

                    // Créer ou mettre à jour la navigation
                    $navigation = new NavigationModel();
                    $navigation->setName($name)
                        ->setLink($link)
                        ->setPosition($selectedPosition)
                        ->setParentId($_POST["parent_id"] ? intval($_POST["parent_id"]) : null)
                        ->setLevel(intval($_POST["level"]))
                        ->setIsInNavbar($isInNavbar);
                    if ($navigation->save()) {
                        $message = "Navigation ajoutée/modifiée avec succès.";
                        header("Location: /admin/navigation");
                    } else {
                        $errors[] = "Erreur lors de l'ajout/modification de la navigation.";
                    }
                } catch (\Exception $e) {
                    $config["inputs"]["name"]["value"] = $_POST["name"];;
                    
                    if ($e->getCode() == 23505) {
                        $errors[] = "Une erreur est survenue : Le nom de navigation \"" . $name . "\" existe déjà. Veuillez choisir un autre nom.";
                    } else {
                        $errors[] = "Une erreur est survenue : " . $e->getMessage();
                    }
                }
            }
        }

        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }




    /**
     * Méthode pour éditer une navigation existante
     */
    public function editNavigation(): void
    {
        $errors = [];
        $message = "";

        // Gestion du formulaire en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_GET['id_navigation']) || empty($_GET['id_navigation'])) {
                header("Location: /admin/navigation");
                exit;
            }

            $id = intval($_GET['id_navigation']);
            $navigationModel = new NavigationModel();
            $navigation = $navigationModel->getNavigationById($id);

            if (!$navigation) {
                $errors[] = "La navigation n'a pas été trouvée.";
            } else {
                
                // Récupérer et valider les données
                try{
                    $name = htmlspecialchars($_POST["name"]);
                    $link = $this->slugify($name);
                    $isInNavbar = (isset($_POST["is_in_navbar"]) && $_POST["is_in_navbar"] == '1') ? 1 : 0;
                    $selectedPosition = intval($_POST["position"]);

                    // Si parent_id est vide, définissez-le à NULL
                    $parentId = !empty($_POST["parent_id"]) ? intval($_POST["parent_id"]) : null;
                    $level = intval($_POST["level"]);

                    // Mettre à jour la navigation
                    $navigation->setName($name)
                            ->setLink($link)
                            ->setPosition($selectedPosition)
                            ->setParentId($parentId) // NULL si pas de parent
                            ->setLevel($level)
                            ->setIsInNavbar($isInNavbar);

                    if ($navigation->save()) {
                        $message = "Navigation modifiée avec succès.";
                    } else {
                        $errors[] = "Erreur lors de la modification de la navigation.";
                    }
                } catch (\Exception $e) {
                    $config["inputs"]["name"]["value"] = $_POST["name"];
                    
                    if ($e->getCode() == 23505) {
                        $errors[] = "Une erreur est survenue : Le nom de navigation \"" . $name . "\" existe déjà. Veuillez choisir un autre nom.";
                    } else {
                        $errors[] = "Une erreur est survenue : " . $e->getMessage();
                    }
                }
                
                if (!isset($_GET['id_navigation']) || empty($_GET['id_navigation'])) {
                    header("Location: /admin/navigation");
                    exit;
                }
    
                $id = intval($_GET['id_navigation']);
                $navigationModel = new NavigationModel();
                $navigation = $navigationModel->getNavigationById($id);
    
                if (!$navigation) {
                    header("Location: /admin/navigation");
                    exit;
                }
    
                // Récupérer les parents et les positions
                $parents = $navigationModel->getParentNavigations();
                $nextPosition = $navigationModel->getNextPosition();
                $positionsInNavbar = $navigationModel->getNavbarPositions();
    
                // Pré-remplir le formulaire
                $form = new NavigationUpdate();
                $config = $form->getConfig([
                    "id" => $navigation->getId(),
                    "name" => $navigation->getName(),
                    "selectedPosition" => $navigation->getPosition(),
                    "selectedParent" => $navigation->getParentId(),
                    "level" => $navigation->getLevel(),
                    "is_in_navbar" => $navigation->getIsInNavbar(),
                    "parents" => $parents,
                    "nextPosition" => $nextPosition,
                    "positionsInNavbar" => $positionsInNavbar
                ]);
                
                $myView = new View("Admin/edit-navigation", "back");
                $myView->assign("configForm", $config);
                $myView->assign("errorsForm", $errors);
                $myView->assign("message", $message);

            }
            header("Location: /admin/navigation");
            exit;
        } 
        // Gestion du formulaire en GET (pré-remplissage)
        else {
            if (!isset($_GET['id_navigation']) || empty($_GET['id_navigation'])) {
                header("Location: /admin/navigation");
                exit;
            }

            $id = intval($_GET['id_navigation']);
            $navigationModel = new NavigationModel();
            $navigation = $navigationModel->getNavigationById($id);

            if (!$navigation) {
                header("Location: /admin/navigation");
                exit;
            }

            // Récupérer les parents et les positions
            $parents = $navigationModel->getParentNavigations();
            $nextPosition = $navigationModel->getNextPosition();
            $positionsInNavbar = $navigationModel->getNavbarPositions();

            // Pré-remplir le formulaire
            $form = new NavigationUpdate();
            $config = $form->getConfig([
                "id" => $navigation->getId(),
                "name" => $navigation->getName(),
                "selectedPosition" => $navigation->getPosition(),
                "selectedParent" => $navigation->getParentId(),
                "level" => $navigation->getLevel(),
                "is_in_navbar" => $navigation->getIsInNavbar(),
                "parents" => $parents,
                "nextPosition" => $nextPosition,
                "positionsInNavbar" => $positionsInNavbar
            ]);
            
            $myView = new View("Admin/edit-navigation", "back");
            $myView->assign("configForm", $config);
            $myView->assign("errorsForm", $errors);
            $myView->assign("message", $message);
        }
    }








    public function showNavigation(): void
    {
        $table = new NavigationTable();
        $configTable = $table->getConfig();

        $navigationModel = new NavigationModel();
        $navigations = $navigationModel->getList(); // Utilisation de getList pour récupérer les données

        $myView = new View("Admin/navigation", "back");
        $myView->assign("configTable", $configTable);
        $myView->assign("data", $navigations);
        $myView->assign("title", "Gestion des Navigations");
    }


    public function deleteNavigation(): void
    {
        if (!isset($_GET["id_navigation"]) || empty($_GET["id_navigation"])) {
            header("Location: /admin/navigation");
            exit;
        }

        $id = intval($_GET["id_navigation"]);
        $navigationModel = new NavigationModel();

        try {
            $navigationModel->setId($id);

            // Supprimer la navigation
            if ($navigationModel->delete()) {
                // Réorganiser les positions après suppression
                $navigationModel->reorderPositions(); // Appelle la méthode pour réorganiser les positions
                header("Location: /admin/navigation?message=Navigation supprimée et positions réorganisées");
            } else {
                header("Location: /admin/navigation?error=Erreur lors de la suppression");
            }
        } catch (\Exception $e) {
            header("Location: /admin/navigation?error=" . $e->getMessage());
        }

        exit;
    }


    private function slugify(string $text): string
        {
            // Remplacer les accents par les caractères correspondants sans accents
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

            // Mettre en minuscule
            $text = strtolower($text);

            // Remplacer les espaces par des tirets
            $text = preg_replace('/\s+/', '-', $text);

            // Supprimer les caractères spéciaux non alphanumériques (garder les tirets)
            $text = preg_replace('/[^a-z0-9\-]/', '', $text);

            // Supprimer les tirets multiples
            $text = preg_replace('/-+/', '-', $text);

            // Supprimer les tirets en début ou fin de chaîne
            $text = trim($text, '-');

            return $text;
        }

}
    