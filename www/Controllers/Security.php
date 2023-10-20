<?php

namespace App\Controllers;

use App\Core\View;

class Security
{

    public function login(): void
    {
        $myView = new View("Security/login", "front");
    }
    public function logout(): void
    {
        $myView = new View("Security/logout", "front");
    }
    public function register(): void
    {
        $myView = new View("Security/register", "front");
    }
    public function passwordForgot()
    {
        $myView = new View("Security/password-forgot", "front");
    }
}
