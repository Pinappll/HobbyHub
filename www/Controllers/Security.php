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
        
    }
    
    public function logout(): void
    {
        echo "Ma page de déconnexion";
    }

    public function register(): void
    {
        
        $myView = new View("Security/register", "front");
       
    }
}
