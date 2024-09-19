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
            [
                "name" => "validation",
                "class" => "td-validation-review",
                "title" => "Validation",
                "method" => ["true" => "POST", "false" => "POST"],
                "action" => ["true" => "/admin/reviews/validate", "false" => "/admin/reviews/refuse"]
            ]
        ];
    }
}