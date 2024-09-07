<?php

namespace App\Tables;

class ReviewTable
{

    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "Id"],
            ["name" => "id_user_review", "title" => "Id User"],
            ["name" => "id_page_review", "title" => "Id Page"],
            ["name" => "content_review", "title" => "Contenu"],
            ["name" => "status_review", "title" => "Status"],
            ["name" => "edit", "title" => "Editer", "type" => "edit", "route" => "/admin/reviews/edit?id_review="],
        ];
    }
}