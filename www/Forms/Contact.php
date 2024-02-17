<?php

namespace App\Forms;

class Contact
{

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "submit" => "Envoyer",
                "class" => "form"
            ],
            "inputs" => [
                "name" => ["type" => "text", "class" => "input-form", "placeholder" => "nom", "minlen" => 2, "required" => true, "error" => "Le nom doit faire plus de 2 caractères"],
                "email" => ["type" => "email", "class" => "input-form", "placeholder" => "email", "required" => true, "error" => "Le format de l'email est incorrect"],
                "subject" => ["type" => "text", "class" => "input-form", "placeholder" => "sujet", "required" => true, "minlen" => 1, "error" => "Le sujet ne peut pas être vide"],

            ],
            "textarea" => [
                "message" => ["class" => "input-form", "placeholder" => "message", "required" => true, "minlen" => 1, "error" => "Le message ne peut pas être vide"]
            ]
            
        ];
    }

}