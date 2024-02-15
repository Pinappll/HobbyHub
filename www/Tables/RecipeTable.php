<?php

namespace App\Tables;

class RecipeTable
{

    public function getConfig(): array
    {
        return [
            ["name" => "title_recipe", "title" => "Titre"],
            ["name" => "ingredient_recipe", "title" => "Ingrédients"],
            ["name" => "instruction_recipe", "title" => "Instructions"],
            ["name" => "image_url_recipe", "title" => "Image"],
        ];
    }
}
