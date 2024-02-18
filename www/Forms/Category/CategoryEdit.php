<?php

namespace App\Forms\Category;

class CategoryEdit
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/category/edit",
                "submit" => "modifier",
                "class" => "form",
                "id" => "form-category-etit",

            ],
            "inputs" => [
                "nameCategory" => ["type" => "text", "class" => "input-form", "placeholder" => "nom de la catégorie de recette", "minlen" => 2, "required" => true, "error" => "Le nom doit faire plus de 2 caractères"],
            ]
        ];
    }
}
