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
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/menus/edit?id="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/menus/delete?id="]
        ];
    }
}
