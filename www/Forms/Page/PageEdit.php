<?php

namespace App\Forms\Page;

class PageEdit
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/pages/edit-page?id=" . $data["page"]->getId(),
                "submit" => "Mofifier",
                "class" => "form",
                "id" => "pageForm",

            ],
            "inputs" => [
                "id"=> ["type" => "hidden", "class" => "input-form", "placeholder" => "id", "required" => true, "error" => "Votre id doit être un nombre"],
                "title_page" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre de page", "minlen" => 2, "required" => true, "error" => "Le titre doit faire plus de 2 caractères", "id" => "title-input'", "value" => $data["page"]->getTitle_page()],
                "name" => ["type" => "select", "class" => "input-form", "placeholder" => "Nom", "required" => true, "error" => "Votre nom doit faire plus de 2 caractères"],
                "content_page" => ["type" => "hidden", "class" => "contentInput", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Pas de contenu de page",],
            ]
        ];
    }
}
