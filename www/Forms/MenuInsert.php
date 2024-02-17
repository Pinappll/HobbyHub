<?php

namespace App\Forms;

class MenuInsert
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/recipes/add",
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-menu-insert",

            ],
            "inputs" => [
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères"],

            ],
            "textarea" => [
                "description" => ["class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre description doit faire plus de 2 caractères"],
            ],
            "select" => [
                "recipe" => ["type" => "select", "class" => "input-form", "placeholder" => "Catégorie", "required" => true, "error" => "Une recette doit être sélectionnée"],
            ],
            "options" => [
                "recipe" => ["Entrée", "Plat", "Dessert", "Boisson"],
            ],
        ];
    }
}
