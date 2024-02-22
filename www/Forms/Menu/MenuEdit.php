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
                "id" => ["type" => "hidden", "value" => $data["id"], "id" => "id_menu"],
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères", "value" => $data["title"]],
                "description" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre description doit faire plus de 2 caractères", "value" => $data["description"]],
                "select_recipe" => ["type" => "select", "class" => "select-category", "placeholder" => "Catégorie", "required" => true, "error" => "Une recette doit être sélectionnée", "name" => "category", "required", "placeholder" => "choisir une catégorie", "error" => "Une catégorie doit être sélectionnée"],
                "recipe" => ["type" => "partiel", "class" => "recipe", "error" => "Une recette doit être sélectionnée", "titre" => "Liste des recettes selectionnées"],
            ],
            "div" => ["class" => "content-recipe", "titre" => "Liste des recettes"],
        ];
    }
}
