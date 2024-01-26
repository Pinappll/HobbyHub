<?php

namespace App\Forms;

class UserChangePassword
{

    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/change-password",
                "submit" => "Changer de mot de passe",
                "class" => "form",
                "id" => "form-change-password"
            ],
            "inputs" => [
                "password" => ["type" => "password", "class" => "input-form", "placeholder" => "Mot de passe", "required" => true, "error" => "Votre mot de passe doit faire plus de 8 caractères avec une  minuscule et chiffre"],
                "passwordConf" => ["type" => "password", "class" => "input-form", "confirm" => "pwd", "placeholder" => "Confirmation", "required" => true, "error" => "Votre mot de passe de confirmation ne correspond pas à votre mot de passe"],
                "token" => ["type" => "hidden", "value" => $data["token"] ?? ""]
            ]
        ];
    }
}
