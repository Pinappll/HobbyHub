<?php

namespace App\Forms;

class SettingUpdate
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/settings/update", // Action vers laquelle soumettre le formulaire
                "submit" => "Mettre à jour le site",
                "class" => "form",
                "enctype" => "multipart/form-data", // Nécessaire pour les fichiers
                "title" => "Paramètres du site" // Titre du formulaire
            ],
            "inputs" => [
                "imageToUpload" => [
                    "type" => "file",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Choisissez le nouveau logo :"
                ],
                // Couleurs génériques
                "couleur_principale" => [
                    "type" => "color",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Couleur principale :",
                    "value" => "#ffffff" // Valeur par défaut (blanc)
                ],
                "couleur_secondaire" => [
                    "type" => "color",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Couleur secondaire :",
                    "value" => "#cccccc" // Valeur par défaut (gris clair)
                ],
                "couleur_accent" => [
                    "type" => "color",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Couleur d'accent :",
                    "value" => "#f8c630" // Valeur par défaut (jaune)
                ],
                "couleur_accent_clair" => [
                    "type" => "color",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Couleur d'accent clair :",
                    "value" => "#fbdd92" // Valeur par défaut (jaune clair)
                ],
            ]
        ];
    }
}
