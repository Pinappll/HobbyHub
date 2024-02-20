<?php

namespace App\Forms\Menu;

class MenuInsert
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/menus/add",
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-menu-insert",

            ],
            "inputs" => [
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères"],
                "description" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre description doit faire plus de 2 caractères"],
                "select_recipe" => ["type" => "select", "class" => "select-category", "placeholder" => "Catégorie", "required" => true, "error" => "Une recette doit être sélectionnée", "name" => "category", "required", "placeholder" => "choisir une catégorie", "error" => "Une catégorie doit être sélectionnée"],
                "recipe" => ["type" => "partiel", "class" => "recipe", "error" => "Une recette doit être sélectionnée", "titre" => "Liste des recettes selectionnées"],
            ],
            "div" => ["class" => "content-recipe", "titre" => "Liste des recettes"],

        ];
    }
}
