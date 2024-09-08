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
            ],
            "inputs" => [
                "imageToUpload" => [
                    "type" => "file",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Choisissez le nouveau logo :"
                ]
            ]
        ];
    }
}
