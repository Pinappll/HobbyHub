<?php

namespace App\Forms;

class UserForgetPassword
{

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/password-forgot",
                "submit" => "Envoyer",
                "class" => "form",
                "id" => "form-forget-password"
            ],
            "inputs" => [
                "email" => ["type" => "email", "class" => "input-form", "placeholder" => "Email", "required" => true, "error" => "Le format de l'email est incorrect"],
            ]
        ];
    }
}
