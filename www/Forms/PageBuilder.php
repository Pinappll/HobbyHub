<?php

namespace App\Forms;

class PageBuilder
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/pages/add-page",
                "class" => "form",
                "submit" => "Enregistrer",
            ],
            "inputs" => [
                "title" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Titre de la page",
                    "required" => true,
                    "minlen" => 2,
                    "error" => "Le titre doit faire au moins 2 caractères",
                ],
            ]
        ];
    }
}
