<?php

namespace App\Forms;

class FooterUpdate
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/settings/updatefooter", // Action vers laquelle soumettre le formulaire
                "submit" => "Mettre à jour le footer",
                "class" => "form",
                "id" => "form-footer",
                "title" => "Paramètres du footer" // Titre du formulaire
            ],
            "inputs" => [
                "name_setting" => ["type" => "text", "class" => "input-form", "placeholder" => "Nom du site", "required" => true, "error" => "Votre nom doit faire plus de 2 caractères"],
                "slogan_setting" => ["type" => "text", "class" => "input-form", "placeholder" => "Slogan", "required" => true, "error" => "Votre slogan doit faire plus de 2 caractères"],
            ]
        ];
    }
}
