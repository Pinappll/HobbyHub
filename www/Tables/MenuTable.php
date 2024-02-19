<?php

namespace App\Tables;

class MenuTable
{

    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "title_menu", "title" => "Titre"],
            ["name" => "description_menu", "title" => "Description"],
        ];
    }
}
