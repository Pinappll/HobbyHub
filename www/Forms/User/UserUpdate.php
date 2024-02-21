<?php

namespace App\Forms\User;

class UserUpdate
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/users/edit",
                "submit" => "Modifier",
                "class" => "form",
            ],
            "inputs" => [
                "id" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Id",
                    "required" => true,
                ],
                "type_user" => [
                    "type" => "select",
                    "class" => "input-form",
                    "placeholder" => "Type d'utilisateur",
                    "options" => [
                        "viewer" => "viewer",
                        "chef" => "chef",
                        "admin" => "admin"
                    ],
                    "required" => true,
                    "error" => "Vous devez sélectionner un type d'utilisateur",
                    "value" => null, 
                ],
            ]
        ];
    }
}
