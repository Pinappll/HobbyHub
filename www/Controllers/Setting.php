<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\SettingUpdate;
use App\Models\Setting as SettingModel; // Alias pour le modèle Setting

class Setting
{
    
    private $cssFilePath = 'easycook-vite/dist/css/style.css'; // Mettez le chemin correct vers votre fichier CSS

    public function setting(): void
    {
        // Récupération et initialisation des couleurs
        $myView = new View("Admin/setting", "back");
        $form = new SettingUpdate();
        $config = $form->getConfig();
        
        $errorsForm = [];
        
        // Récupérer les paramètres existants
        $settingModel = new SettingModel();
        $settings = $settingModel->getOneBy(["id" => 1], "array");

        // Vérifier que le champ 'color_setting' existe et qu'il contient les bonnes données
        if ($settings && isset($settings['color_setting'])) {
            $currentColors = json_decode($settings['color_setting'], true);
        } else {
            // Couleurs par défaut
            $currentColors = [
                'couleur_principale' => '#ffffff',
                'couleur_secondaire' => '#cccccc',
                'couleur_accent' => '#f8c630',
                'couleur_accent_clair' => '#fbdd92'
            ];
        }

        // Injecter les valeurs des couleurs dans le formulaire
        $config['inputs']['couleur_principale']['value'] = $currentColors['couleur_principale'];
        $config['inputs']['couleur_secondaire']['value'] = $currentColors['couleur_secondaire'];
        $config['inputs']['couleur_accent']['value'] = $currentColors['couleur_accent'];
        $config['inputs']['couleur_accent_clair']['value'] = $currentColors['couleur_accent_clair'];

        // Assigner les données à la vue
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errorsForm);
        $myView->assign("title", "Paramètres du site");
    }


    public function update(): void
{
    $targetDir = "dist/assets/images/"; // Dossier où stocker le logo
    $uploadOk = 1;
    $errors = [];
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newLogoUrl = null;

        // Vérifiez si une image a été téléchargée
        if (isset($_FILES["imageToUpload"]) && $_FILES["imageToUpload"]["error"] == UPLOAD_ERR_OK) {
            $imageFileType = strtolower(pathinfo($_FILES["imageToUpload"]["name"], PATHINFO_EXTENSION));

            // Vérifiez si c'est bien une image
            $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
            if ($check === false) {
                $errors['imageToUpload'] = "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }

            // Vérifiez les formats autorisés
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $errors['imageToUpload'] = "Seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
                $uploadOk = 0;
            }

            // Si tout est OK, on continue
            if ($uploadOk == 1) {
                $targetFile = $targetDir . "logo." . $imageFileType;

                // Supprimer l'ancien logo s'il existe
                if (file_exists($targetFile)) {
                    unlink($targetFile);
                }

                // Déplacer le fichier uploadé dans le dossier et le renommer
                if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $targetFile)) {
                    $message = "Le logo a été mis à jour avec succès.";
                    $newLogoUrl = $targetFile;
                } else {
                    $errors['imageToUpload'] = "Erreur lors du téléchargement du fichier.";
                }
            }
        } else {
            $message = "Aucune image n'a été téléchargée.";
        }

        // Récupérer les nouvelles couleurs soumises
        $newColors = [
            'couleur_principale' => $_POST['couleur_principale'] ?? '#ffffff',
            'couleur_secondaire' => $_POST['couleur_secondaire'] ?? '#cccccc',
            'couleur_accent' => $_POST['couleur_accent'] ?? '#f8c630',
            'couleur_accent_clair' => $_POST['couleur_accent_clair'] ?? '#fbdd92'
        ];

        // Mettre à jour les couleurs dans la base de données
        $settingModel = new SettingModel();
        $success = $settingModel->updateSettings([
            'color_setting' => json_encode($newColors),
            'logo_url_setting' => $newLogoUrl 
        ]);

        if ($success) {
            $message .= " Les couleurs et le logo ont été mis à jour avec succès.";
            $this->updateCSS($newColors); // Mettre à jour le CSS avec les nouvelles couleurs
        } else {
            $errors['update'] = "Erreur lors de la mise à jour des couleurs ou du logo.";
        }
    }

    // Recharger le formulaire après la soumission
    $form = new SettingUpdate();
    $config = $form->getConfig();

    // Mettre à jour le formulaire avec les nouvelles couleurs
    $config['inputs']['couleur_principale']['value'] = $newColors['couleur_principale'];
    $config['inputs']['couleur_secondaire']['value'] = $newColors['couleur_secondaire'];
    $config['inputs']['couleur_accent']['value'] = $newColors['couleur_accent'];
    $config['inputs']['couleur_accent_clair']['value'] = $newColors['couleur_accent_clair'];

    // Retourner à la vue settings avec les erreurs, la config et le message
    $myView = new View("Admin/setting", "back");
    $myView->assign("configForm", $config); 
    $myView->assign("errorsForm", $errors); 
    $myView->assign("message", $message); 
}


    private function updateCSS(array $colors): void
    {
        $cssFilePath = 'easycook-vite/dist/css/style.css'; // Remplacez par le chemin réel de votre fichier CSS compilé

        // Charger le contenu du fichier CSS
        $cssContent = file_get_contents($cssFilePath);

        // Remplacer les couleurs dans le fichier CSS en fonction des noms de variables CSS
        $cssContent = preg_replace('/(--couleur-blanc:)[^;]+;/', '$1 ' . $colors['couleur_principale'] . ';', $cssContent);
        $cssContent = preg_replace('/(--couleur-gris-clair:)[^;]+;/', '$1 ' . $colors['couleur_secondaire'] . ';', $cssContent);
        $cssContent = preg_replace('/(--couleur-jaune:)[^;]+;/', '$1 ' . $colors['couleur_accent'] . ';', $cssContent);
        $cssContent = preg_replace('/(--couleur-jaune-clair:)[^;]+;/', '$1 ' . $colors['couleur_accent_clair'] . ';', $cssContent);

        // Sauvegarder les modifications dans le fichier CSS
        file_put_contents($cssFilePath, $cssContent);

        // Effacer le cache des statuts de fichiers pour forcer le rechargement du cache du navigateur
        clearstatcache();
    }

    
    public function updatefooter(): void
    {

        // update de name setting 
        $settingModel = new SettingModel();
        $settingModel->updateSettings([
            'name_setting' => $_POST['name_setting'] ?? '',
            'slogan_setting' => $_POST['slogan_setting'] ?? '',
        ]);

        // Recharger le formulaire après la soumission
        $form = new SettingUpdate();
        $config = $form->getConfig();

        // Retourner à la vue settings avec les erreurs, la config et le message
        $myView = new View("Admin/setting", "back");
        $myView->assign("configForm", $config); // Recharger le formulaire après soumission
        $myView->assign("message", "Les informations du footer ont été mises à jour avec succès.");


    }

    



}
