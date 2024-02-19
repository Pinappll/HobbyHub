<?php

namespace App\Controllers;

use App\Core\View;

class Setting
{

    
    public function setting(): void
    {
        $myView = new View("Admin/setting", "back");
    }
}
