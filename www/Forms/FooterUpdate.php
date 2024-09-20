<?php

namespace App\Forms;

class FooterUpdate
{
    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/admin/footer/update", // Action vers laquelle soumettre le formulaire
                "submit" => "Mettre à jour le footer",
                "class" => "form",
                "id" => "form-footer",
                "title" => "Paramètres du footer" // Titre du formulaire
            ],
            "inputs" => [
                "name_setting" => [
                    "type" => "text", 
                    "class" => "input-form", 
                    "placeholder" => "Nom du site", 
                    "minlen" => 2, 
                    "required" => true, 
                    "error" => "Votre nom doit faire plus de 2 caractères"
                ],
                "slogan_setting" => [
                    "type" => "text", 
                    "class" => "input-form", 
                    "placeholder" => "Slogan", 
                    "minlen" => 2, 
                    "required" => true, 
                    "error" => "Votre slogan doit faire plus de 2 caractères"
                ],
                "link_facebook_setting" => [
                    "type" => "url", // Passer à "url" pour valider au format URL
                    "class" => "input-form", 
                    "placeholder" => "Lien Facebook", 
                    "required" => true, 
                    "error" => "Votre lien Facebook doit être une URL valide"
                ],
                "link_twitter_setting" => [
                    "type" => "url", // Passer à "url" pour valider au format URL
                    "class" => "input-form", 
                    "placeholder" => "Lien Twitter", 
                    "required" => true, 
                    "error" => "Votre lien Twitter doit être une URL valide"
                ],
                "link_instagram_setting" => [
                    "type" => "url", // Passer à "url" pour valider au format URL
                    "class" => "input-form", 
                    "placeholder" => "Lien Instagram", 
                    "required" => true, 
                    "error" => "Votre lien Instagram doit être une URL valide"
                ],
            ]
        ];
    }
}
