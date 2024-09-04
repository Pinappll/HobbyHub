<?php

namespace App\Forms;

class UserLogin
{

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "submit" => "Se connecter",
                "class" => "form"
            ],
            "inputs" => [
                "email" => ["type" => "email", "class" => "input-form", "placeholder" => "email", "required" => true, "error" => "identifiant incorrect"],
                "password" => ["type" => "password", "class" => "input-form", "placeholder" => "mot de passe", "required" => true, "error" => "identifiant incorrect"],
            ]
        ];
    }
}
