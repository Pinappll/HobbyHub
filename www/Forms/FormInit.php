<?php

namespace App\Forms;

class FormInit
{
    public function getConfig(array $data = []): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "", // Spécifiez l'action si nécessaire
                "submit" => "Créer la base de données",
                "class" => "form", // La classe "form" ici correspond au style du form SCSS
                "enctype" => "multipart/form-data",
                "title" => "Installeur", // Ajout d'un titre au formulaire
            ],
            "inputs" => [
                "dbHost" => [
                    "type" => "text",
                    "class" => "input-form", // Correspond à l'input stylisé en SCSS
                    "placeholder" => "Hôte de la base de données",
                    "required" => true,
                    "label" => "Hôte de la base de données :",
                    "value" => $data["dbHost"] ?? ""
                ],
                "dbName" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom de la base de données",
                    "required" => true,
                    "label" => "Nom de la base de données :",
                    "value" => $data["dbName"] ?? ""
                ],
                "dbUser" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Utilisateur de la base de données",
                    "required" => true,
                    "label" => "Utilisateur de la base de données :",
                    "value" => $data["dbUser"] ?? ""
                ],
                "dbPassword" => [
                    "type" => "password",
                    "class" => "input-form",
                    "placeholder" => "Mot de passe de la base de données",
                    "required" => true,
                    "label" => "Mot de passe de la base de données :"
                ],
                // Champs Nom et Prénom séparés
                "nom" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom",
                    "required" => true,
                    "label" => "Nom :",
                    "value" => $data["nom"] ?? ""
                ],
                "prenom" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Prénom",
                    "required" => true,
                    "label" => "Prénom :",
                    "value" => $data["prenom"] ?? ""
                ],
                "mail" => [
                    "type" => "email",
                    "class" => "input-form",
                    "placeholder" => "Mail",
                    "required" => true,
                    "label" => "Mail :",
                    "value" => $data["mail"] ?? ""
                ],
                "password" => [
                    "type" => "password",
                    "class" => "input-form",
                    "placeholder" => "Mot de passe",
                    "required" => true,
                    "label" => "Mot de passe :",
                    "error" => "Votre mot de passe doit faire plus de 8 caractères avec une majuscule et un chiffre"
                ],
                "siteName" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Nom du site",
                    "required" => true,
                    "label" => "Nom du site :",
                    "value" => $data["siteName"] ?? ""
                ],
                "slogan" => [
                    "type" => "text",
                    "class" => "input-form",
                    "placeholder" => "Slogan",
                    "required" => true,
                    "label" => "Slogan :",
                    "value" => $data["slogan"] ?? ""
                ],
                "imageToUpload" => [
                    "type" => "file",
                    "class" => "input-form",
                    "required" => true,
                    "label" => "Logo :"
                ]
            ]
        ];
    }
}
