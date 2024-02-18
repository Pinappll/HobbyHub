<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Page;


class PageController
{

    
    public function showPages(): void
    {
        $myView = new View("Admin/pages", "back");

        $myView->assign("title", "Liste des pages");
        $myView->assign("description", "Liste des pages du site");

        
        $page = new Page();
        $pages = $page->findAll();
       

        $myView->assign("pages", $pages);

    }

    public function addPage(): void
    {
        $myView = new View("Admin/page-add", "back");
        $myView->assign("title", "Ajouter une page");
        $myView->assign("description", "Ajouter une page au site");
    }

    
}