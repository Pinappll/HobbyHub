<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\SettingUpdate;

class Setting
{
    public function setting(): void
    {
        $myView = new View("Admin/setting", "back");
        $form = new SettingUpdate();
        $config = $form->getConfig();
        $errors = [];
        $myView->assign("configForm", $config); // Passer le formulaire à la vue
        $myView->assign("errorsForm", $errors); // Passer les erreurs (même vide) à la vue
        $myView->assign("title", "Paramètres du site"); // Passer le message (même vide) à la vue
    }

    public function update(): void
    {
        $targetDir = "dist/assets/images/"; // Dossier où stocker le logo
        $uploadOk = 1;
        $errors = [];
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageToUpload"])) {
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
