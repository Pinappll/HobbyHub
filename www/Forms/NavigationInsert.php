<?php

namespace App\Forms;

class NavigationInsert
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/navigation/add",
                "submit" => "ajouter",
                "class" => "form",
                "id" => "form-navigation-insert",
            ],
            "inputs" => [
                "name" => ["type" => "text", "class" => "input-form", "placeholder" => "Nom", "required" => true, "error" => "Votre nom doit faire plus de 2 caractères"],
                "link" => ["type" => "text", "class" => "input-form", "placeholder" => "Lien", "required" => true, "error" => "Votre lien doit faire plus de 2 caractères"],
                "position" => ["type" => "number", "class" => "input-form", "placeholder" => "Position", "required" => true, "error" => "Votre position doit être un nombre"],
                "parent_id" => ["type" => "number", "class" => "input-form", "placeholder" => "Parent", "required" => false, "error" => "Votre parent doit être un nombre"],
                "level" => ["type" => "number", "class" => "input-form", "placeholder" => "Niveau", "required" => false, "error" => "Votre niveau doit être un nombre"],
            ]
        ];
    }
}