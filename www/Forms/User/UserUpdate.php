<?php

namespace App\Forms\User;

class UserUpdate
{
    public function getConfig(object $data = null): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/users/edit?id=" . ($data->getId() ?? ''),
                "submit" => "Modifier",
                "class" => "form",
            ],
            "inputs" => [
                "id" => [
                    "type" => "hidden", 
                    "value" => $data->getId() ?? '', // Utilisation de l'ID utilisateur récupéré
                    "required" => true,
                ],
                "lastname_user" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom",
                    "minlen" => 2,
                    "required" => true,
                    "error" => "Le nom doit faire plus de 2 caractères",
                    "value" => $data->getLastname_user() ?? ''  // Valeur dynamique du nom de famille
                ],
                "firstname_user" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Prénom",
                    "minlen" => 2,
                    "required" => true,
                    "error" => "Le prénom doit faire plus de 2 caractères",
                    "value" => $data->getFirstname_user() ?? ''  // Valeur dynamique du prénom
                ],
                "email_user" => [
                    "type" => "email",
                    "class" => "input-form",
                    "placeholder" => "Email",
                    "required" => true,
                    "error" => "Le format de l'email est incorrect",
                    "value" => $data->getEmail_user() ?? ''  // Valeur dynamique de l'email
                ],
                "password_user" => [
                    "type" => "password", 
                    "class" => "input-form", 
                    "placeholder" => "Mot de passe (laisser vide si inchangé)", 
                    "required" => false, 
                    "error" => "Votre mot de passe doit faire plus de 8 caractères avec une minuscule et un chiffre"
                ],
                "type_user" => [
                    "type" => "select",
                    "class" => "input-form",
                    "placeholder" => "Type d'utilisateur",
                    "options" => [
                        "viewer" => "Viewer",
                        "chef" => "Chef",
                        "admin" => "Admin"
                    ],
                    "required" => true,
                    "error" => "Vous devez sélectionner un type d'utilisateur",
                    "value" => $data->getType_user() ?? null  // Valeur dynamique pour le type d'utilisateur
                ],
                "is_verified_user" => [
                    "type" => "checkbox",
                    "class" => "input-form",
                    "label" => "Vérifié",
                    "value" => [
                        [
                            "id" => "verified", 
                            "name" => "Vérifié", 
                            "checked" => !empty($data->getIsverified_user())  // Dynamique pour cocher la case si l'utilisateur est vérifié
                        ]
                    ],
                    "required" => false 
                ]
            ]
        ];
    }
}
