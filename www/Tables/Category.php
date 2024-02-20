<?php

namespace App\Tables;

class Category
{

    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "name_category", "title" => "Titre"],
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/category/edit?id_category="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/category/delete?id_category="]
        ];
    }
}
