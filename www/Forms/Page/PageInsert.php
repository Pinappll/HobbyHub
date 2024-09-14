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
                "name" => ["type" => "text", "class" => "input-form", "placeholder" => "Nom", "required" => true, "error" => "Votre nom doit faire plus de 2 caractères"],
                "link" => ["type" => "text", "class" => "input-form", "placeholder" => "Lien", "required" => true, "error" => "Votre lien doit faire plus de 2 caractères"],
                "position" => ["type" => "number", "class" => "input-form", "placeholder" => "Position", "required" => true, "error" => "Votre position doit être un nombre"],
                "parent_id" => ["type" => "select", "class" => "input-form", "placeholder" => "Parent", "required" => true, "error" => "Votre parent doit être un nombre", "options" => $navigations, "value" => $navigations_id], 
                "level" => ["type" => "number", "class" => "input-form", "placeholder" => "Niveau", "required" => true, "error" => "Votre niveau doit être un nombre"],
                "content_page" => ["type" => "hidden", "class" => "contentInput", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Pas de contenu de page"],
            ]
        ];
    }
}
