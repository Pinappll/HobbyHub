<?php

namespace App\Forms\User;

class UserInsert
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/users/add",
                "submit" => "Enregistrer",
                "class" => "form",
            ],
            "inputs" => [
                "lastname_user" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom",
                    "minlen" => 2,
                    "required" => true,
                    "error" => "Le nom doit faire plus de 2 caractères"
                ],
                "firstname_user" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Prénom",
                    "minlen" => 2,
                    "required" => true,
                    "error" => "Le prénom doit faire plus de 2 caractères"
                ],
                "email_user" => [
                    "type" => "email",
                    "class" => "input-form",
                    "placeholder" => "Email",
                    "required" => true,
                    "error" => "Le format de l'email est incorrect"
                ],
                "password_user" => ["type" => "password", "class" => "input-form", "placeholder" => "Mot de passe à modifier par l'utilisateur", "required" => true, "error" => "Votre mot de passe doit faire plus de 8 caractères avec une  minuscule et chiffre"],
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
                "is_verified_user" => [
                    "type" => "checkbox",
                    "class" => "input-form",
                    "label" => "Vérifié",
                    "value" => [
                        [
                            "id" => "verified", // L'attribut 'id' pour la balise input
                            "name" => "Vérifié", // Le texte qui sera utilisé pour le label
                            "checked" => false // La checkbox n'est pas cochée par défaut
                        ]
                    ],
                    "required" => false 
                ]
            ]
        ];
    }
}
