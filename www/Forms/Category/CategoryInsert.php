<?php

namespace App\Forms\Category;

class CategoryInsert
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/category/add",
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-category-insert",

            ],
            "inputs" => [
                "nameCategory" => ["type" => "text", "class" => "input-form", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Le nom doit faire plus de 2 caractères"],
            ]
        ];
    }
}
