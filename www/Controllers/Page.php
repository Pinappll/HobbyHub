<?php

namespace App\Controllers;

use App\Core\View;

class Page
{

    public function createPage(): void
    {
        $myView = new View("Page/createPage", "front");
    }
    public function readPage(): void
    {
        $myView = new View("Page/readPage", "front");
    }
    public function updatePage(): void
    {
        $myView = new View("Page/updatePage", "front");
    }
    public function deletePage(): void
    {
        $myView = new View("Page/deletePage", "front");
    }
    public function showPages(): void
    {
        $myView = new View("Admin/pages", "back");
    }
}