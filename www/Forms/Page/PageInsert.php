<?php

namespace App\Forms\Page;

class PageInsert
{

    public function getConfig(array $data = []): array
    {
        $navigations_id = isset($data['navigations_id']) ? $data['navigations_id'] : null;
        $navigations = isset($data['navigations']) ? $data['navigations'] : null;
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/pages/add-page",
                "submit" => "Ajouter",
                "class" => "form",
                "id" => "pageForm",

            ],
            "inputs" => [
                "title_page" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre de page", "minlen" => 2, "required" => true, "error" => "Le titre doit faire plus de 2 caractères", "id" => "title-input'"],
                
                "select_navigation" => ["type" => "select", "class" => "input-form", "placeholder" => "Veuillez sélectionner une navigation", "required" => true, "error" => "Veuillez sélectionner une navigation"],
                "content_page" => ["type" => "hidden", "class" => "contentInput", "required" => true, "error" => "Pas de contenu de page"],
            ]
        ];
    }
}
