<?php

namespace App\Tables;

class NavigationTable
{

    public function getConfig(): array
    {
        
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "name", "title" => "Nom"],
            ["name" => "link", "title" => "Lien"],
            ["name" => "position", "title" => "Position"],
            ["name" => "parent_id", "title" => "Parent"],
            ["name" => "level", "title" => "Niveau"],
        ];

    }
}
