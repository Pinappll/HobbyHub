<?php

namespace App\Forms\Menu;

class MenuEdit
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/menus/edit?id=" . $data["id"],
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-menu-edit",

            ],
            "inputs" => [
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères", "value" => $data["title"]] ,
                "description" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre description doit faire plus de 2 caractères", "value" => $data["description"]],
                "search_recipe" => ["type" => "text", "id"=>"search_recipe","class" => "input-form", "placeholder" => "Rechercher une recette", "required" => false, "error" => "Votre recherche doit faire plus de 2 caractères", "value" => $data["search_recipe"] ?? ""],
                "recipe" => ["type" => "partiel", "class" => "recipe", "error" => "Une recette doit être sélectionnée", "titre" => "Liste des recettes selectionnées", "value" => $data["recipe"]?? ""],
            ],
            "div" => ["class" => "content-recipe", "titre" => "Liste des recettes"],
        ];
    }
}
