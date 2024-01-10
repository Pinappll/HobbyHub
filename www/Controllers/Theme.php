<?php

namespace App\Controllers;

use App\Core\View;

class Theme
{

    
    public function showThemes(): void
    {
        $myView = new View("Admin/themes", "back");
    }
}
