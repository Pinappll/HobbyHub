<?php

namespace App\Tables;

class ReviewTable
{

    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "id_user_review", "title" => "Id User"],
            ["name" => "id_recipie_review", "title" => "Id Recipie"],
            ["name" => "title_review", "title" => "Titre"],
            ["name" => "content_review", "title" => "Contenu"],
            ["name" => "status_review", "title" => "Status"],
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/reviews/edit?id_review="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/reviews/delete?id_review="]
        ];
    }
}