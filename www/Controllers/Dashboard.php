<?php

namespace App\Controllers;

use App\Core\View;

class Dashboard
{

    
    public function dashboard(): void
    {
        $myView = new View("Admin/admin-dashboard", "back");
    }
}
