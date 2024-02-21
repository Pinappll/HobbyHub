<?php

namespace App\Tables;

class UserTable
{
    public function getConfig(): array
    {
        return [
            ["name" => "id", "title" => "ID"],
            ["name" => "lastname_user", "title" => "Nom"],
            ["name" => "firstname_user", "title" => "Prénom"],
            ["name" => "email_user", "title" => "Email"],
            ["name" => "is_verified_user", "title" => "Vérifié"],
            ["name" => "type_user", "title" => "Type d'utilisateur"],
            ["name" => "is_deleted", "title" => "Supprimé"],
            ["name" => "inserted_at", "title" => "Date d'inscription"],
            ["name" => "updated_at", "title" => "Dernière mise à jour"],
            ["name" => "edit", "title" => "Éditer", "type" => "edit", "route" => "/admin/users/edit?id="],
            ["name" => "delete", "title" => "Supprimer", "type" => "delete", "route" => "/admin/users/delete?id="]
        ];
    }
}
