<?php

namespace App\Tables;

class PageTable
{
    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "ID"],
            ["name" => "title_page", "title" => "Titre"],
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/pages/edit-page?id="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/pages/delete-page?id="]
        ];
    }
}
