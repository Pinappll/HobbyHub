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
                "search_recipe" => ["type" => "text", "id"=>"search_recipe","class" => "input-form", "placeholder" => "Rechercher une recette", "required" => false, "error" => "Votre recherche doit faire plus de 2 caractères"],
                "recipe" => ["type" => "partiel", "class" => "recipe", "error" => "Une recette doit être sélectionnée", "titre" => "Liste des recettes selectionnées", "view" => "Partiel/listeSelectedRecipe.view.php", ],
            ],


        ];
    }
}
