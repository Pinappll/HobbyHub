<?php

namespace App\Forms\Recipe;

class RecipeUpdate
{

    public function getConfig(array $data): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/recipes/edit?id_recipe=" . $data["id_recipe"] ?? "",
                "enctype" => "multipart/form-data",
                "submit" => "modifier",
                "class" => "form",
                "id" => "form-recipe-update",

            ],
            "inputs" => [
                "id_user" => ["type" => "hidden"],
                "id_recipe" => ["type" => "hidden"],
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères", "value" => $data["title"] ?? ""],
                "ingredients_recipe" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Ingrédients", "required" => true, "error" => "Vos ingrédients doivent faire plus de 2 caractères"],
                "instruction_recipe" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre contenu doit faire plus de 2 caractères"],
                "inputFileImage" => ["type" => "file", "class" => "input-form", "placeholder" => "Image", "required" => false, "error" => ["size" => "Votre image est trop lourde", "type" => "Votre image n'est pas au bon format"]],
                "categories" => ["type" => "checkbox", "class" => "input-form", "placeholder" => "Catégories", "value" => $data["id_categories"] ?? ""],
            ]
        ];
    }
}
