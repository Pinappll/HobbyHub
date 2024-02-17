<?php

namespace App\Tables;

class Category
{

    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "name_category", "title" => "Titre"],
        ];
    }
}
