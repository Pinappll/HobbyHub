<?php

namespace App\Forms;


class ReviewEdit
{
    public function getConfig(array $data): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/reviews/edit?id_review=" . $data["id_review"] ?? "",
                "submit" => "modifier",
                "class" => "form",
                "id" => "form-review-update",
            ],
            "inputs" => [
                "id_user_review" => ["type" => "hidden"],
                "id_recipie_review" => ["type" => "hidden"],
                "id_review" => ["type" => "hidden"],
                "status_review" => ["type" => "select", "class" => "input-form", "placeholder" => "Status", "required" => true, "error" => "Votre status doit être un nombre", "options" => ["0" => "attente", "1" => "validé", "2" => "refusé"], "value" => $data["status_review"] ?? ""],
            ]
        ];
    }
}