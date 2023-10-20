<?php

namespace App\Controllers;

use App\Core\View;

class Menu
{

    public function createMenu(): void
    {
        $myView = new View("Menu/createMenu", "front");
    }
    public function readMenu(): void
    {
        $myView = new View("Menu/readMenu", "front");
    }
    public function updateMenu(): void
    {
        $myView = new View("Menu/updateMenu", "front");
    }
    public function deleteMenu(): void
    {
        $myView = new View("Menu/deleteMenu", "front");
    }
}
