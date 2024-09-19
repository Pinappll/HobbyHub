<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\SettingUpdate;
use App\Models\Setting as SettingModel; // Alias pour le modèle Setting

class Setting
{
    public function setting(): void
{
    $myView = new View("Admin/setting", "back");
    $form = new SettingUpdate();
    $config = $form->getConfig();
    
    $errorsForm = []; // Définir un tableau vide pour éviter l'erreur Undefined variable

    // Récupérer les paramètres existants ou les couleurs par défaut
    $settingModel = new SettingModel();
    $settings = $settingModel->getOneBy(["id" => 1]); // Suppose qu'il y a un enregistrement id=1 pour les paramètres

    // Couleurs par défaut (tirées de _globals.scss)
    $defaultColors = [
        'couleur_principale' => '#ffffff',
        'couleur_secondaire' => '#cccccc',
        'couleur_accent' => '#f8c630',
        'couleur_accent_clair' => '#fbdd92'
    ];

    // Injecter les valeurs des couleurs dans le formulaire
    $currentColors = isset($settings->color_setting) ? json_decode($settings->color_setting, true) : [];
    $config['inputs']['couleur_principale']['value'] = $currentColors['couleur_principale'] ?? $defaultColors['couleur_principale'];
    $config['inputs']['couleur_secondaire']['value'] = $currentColors['couleur_secondaire'] ?? $defaultColors['couleur_secondaire'];
    $config['inputs']['couleur_accent']['value'] = $currentColors['couleur_accent'] ?? $defaultColors['couleur_accent'];
    $config['inputs']['couleur_accent_clair']['value'] = $currentColors['couleur_accent_clair'] ?? $defaultColors['couleur_accent_clair'];

    // Assigner les données à la vue
    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errorsForm); // Passer un tableau vide à la vue
    $myView->assign("title", "Paramètres du site");
}


    public function update(): void
    {
        $targetDir = "dist/assets/images/"; // Dossier où stocker le logo
        $uploadOk = 1;
        $errors = [];
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                    // Supprimer l'ancien logo
                    if (file_exists($targetFile)) {
                        unlink($targetFile); // Supprimer l'ancien logo
                    }

                    // Déplacer le fichier uploadé dans le dossier et le renommer
                    if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $targetFile)) {
                        $message = "Le logo a été mis à jour avec succès.";
                    } else {
                        $errors['imageToUpload'] = "Erreur lors du téléchargement du fichier.";
                    }
                }
            }

            // Récupérer les nouvelles couleurs soumises
            $newColors = [
                'couleur_principale' => $_POST['couleur_principale'] ?? '#ffffff',
                'couleur_secondaire' => $_POST['couleur_secondaire'] ?? '#cccccc',
                'couleur_accent' => $_POST['couleur_accent'] ?? '#f8c630',
                'couleur_accent_clair' => $_POST['couleur_accent_clair'] ?? '#fbdd92'
            ];

            // Mettre à jour les couleurs dans la base de données en utilisant l'alias SettingModel
            $settingModel = new SettingModel(); // Utilisation de l'alias
            $settingModel->updateSettings([
                'color_setting' => json_encode($newColors) // Stocker les couleurs sous forme JSON
            ]);

            $message .= " Les couleurs ont été mises à jour avec succès.";
        }

        // Recharger le formulaire après la soumission
        $form = new SettingUpdate();
        $config = $form->getConfig();

        // Retourner à la vue settings avec les erreurs, la config et le message
        $myView = new View("Admin/setting", "back");
        $myView->assign("configForm", $config); // Recharger le formulaire après soumission
        $myView->assign("errorsForm", $errors); // Passer les erreurs à la vue (même s'il n'y a pas d'erreurs)
        $myView->assign("message", $message); // Passer le message de succès/échec
    }
}
