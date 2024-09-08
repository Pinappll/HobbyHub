<?php

namespace App\Forms;

class ExportForm
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/export/export", // Action vers laquelle soumettre le formulaire
                "submit" => "Exporter la solution",
                "class" => "form",
            ],
            "inputs" => [
                // Pas d'inputs ici, juste un bouton d'exportation
            ]
        ];
    }
}
