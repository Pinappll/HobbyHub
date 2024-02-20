<?php

namespace App\Forms\Page;

class formPage
{

    public function getConfig(array $data = []): array
    {
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
                "select-url" => ["type" => "select", "class" => "input-form", "placeholder" => "url de la page", "minlen" => 2, "required" => true, "error" => "Pas de contenu de page"],
                "content_page" => ["type" => "hidden", "class" => "contentInput", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Pas de contenu de page"],
            ]
        ];
    }
}
