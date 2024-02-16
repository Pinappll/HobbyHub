<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Page;


class PageController
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

        $myView->assign("title", "Liste des pages");
        $myView->assign("description", "Liste des pages du site");

        
        $page = new Page();
        $pages = $page->findAll();
       

        $myView->assign("pages", $pages);


    }
}