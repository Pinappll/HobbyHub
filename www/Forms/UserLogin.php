<?php

namespace App\Forms;

class UserLogin
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/login",
                "submit" => "Se connecter",
                "class" => "form"
            ],
            "inputs" => [
                "email" => [
                    "type" => "email", 
                    "class" => "input-form", 
                    "placeholder" => "Email", 
                    "required" => true, 
                    "error" => "Identifiant incorrect"
                ],
                "password" => [
                    "type" => "password", 
                    "class" => "input-form", 
                    "placeholder" => "Mot de passe", 
                    "required" => true, 
                    "error" => "Identifiant incorrect"
                ],
            ]
        ];
    }
}
