<?php

namespace App\Forms\Page;

class PageEdit
{

    public function getConfig(array $data = []): array
    {
        $navigations_id = isset($data['navigations_id']) ? $data['navigations_id'] : null;
        $navigations = isset($data['navigations']) ? $data['navigations'] : null;
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
                "name" => ["type" => "text", "class" => "input-form", "placeholder" => "Nom", "required" => true, "error" => "Votre nom doit faire plus de 2 caractères", "value" => $data["navigation"]->getName()],
                "link" => ["type" => "text", "class" => "input-form", "placeholder" => "Lien", "required" => true, "error" => "Votre lien doit faire plus de 2 caractères", "value" => $data["navigation"]->getLink()],
                "position" => ["type" => "number", "class" => "input-form", "placeholder" => "Position", "required" => true, "error" => "Votre position doit être un nombre", "value" => $data["navigation"]->getPosition()],
                "parent_id" => ["type" => "select", "class" => "input-form", "placeholder" => "Parent", "required" => true, "error" => "Votre parent doit être un nombre", "options" => $navigations, "value" => $data["navigation"]->getParent_id()], 
                "level" => ["type" => "number", "class" => "input-form", "placeholder" => "Niveau", "required" => true, "error" => "Votre niveau doit être un nombre", "value" => $data["navigation"]->getLevel()],
                "content_page" => ["type" => "hidden", "class" => "contentInput", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Pas de contenu de page",],
            ]
        ];
    }
}
