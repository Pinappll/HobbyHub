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
            ["name" => "is_in_navbar", "title" => "Dans la navbar"],
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/navigation/edit?id_navigation="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/navigation/delete?id_navigation="]
            
        ];

    }
}
