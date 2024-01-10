<?php

namespace App\Controllers;

use App\Core\View;

class User
{

    public function createAdmin(): void
    {
        $myView = new View("User/createAdmin", "front");
    }
    public function readAdmin(): void
    {
        $myView = new View("User/readAdmin", "front");
    }
    public function updateAdmin(): void
    {
        $myView = new View("User/updateAdmin", "front");
    }
    public function deleteAdmin(): void
    {
        $myView = new View("User/deleteAdmin", "front");
    }
    public function showUsers(): void
    {
        $myView = new View("Admin/users", "back");
    }
    
}
