<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\BuildForm;
use App\Forms\UserInsert;


class Security
{

    public function login(): void
    {

        $myView = new View("Security/login", "front");
        $userForm = new UserInsert();
        $userForm->render();
    }
    public function logout(): void
    {
        echo "Ma page de déconnexion";
    }
    public function register(): void
    {
        echo "Ma page d'inscription";
    }
}
