<?php

namespace App\Forms;

class RecipeInsert
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/recipes/add",
                "enctype" => "multipart/form-data",
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-recipe-insert",

            ],
            "inputs" => [
                "id_user" => ["type" => "hidden", "value" => $_SESSION["user_id"]],
                "title" => ["type" => "text", "class" => "input-form", "placeholder" => "Titre", "required" => true, "error" => "Votre titre doit faire plus de 2 caractères"],
                "ingredients_recipe" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Ingrédients", "required" => true, "error" => "Vos ingrédients doivent faire plus de 2 caractères"],
                "instruction_recipe" => ["type" => "textarea", "class" => "input-form", "placeholder" => "Contenu", "required" => true, "error" => "Votre contenu doit faire plus de 2 caractères"],
                "inputFileImage" => ["type" => "file", "class" => "input-form", "placeholder" => "Image", "required" => true, "error" => ["size" => "Votre image est trop lourde", "type" => "Votre image n'est pas au bon format"]],
            ]
        ];
    }
}
