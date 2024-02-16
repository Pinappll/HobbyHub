<?php

namespace App\Controllers;

use App\Core\View;

class Main
{
    public function home(): void
    {
        $myView = new View("Main/home", "front");
        $myView->assign("title", "Accueil");
        $myView->assign("description", "Bienvenue sur le site de recettes de cuisine");
    }


    // public function aboutUs(): void
    // {
    //     $myView = new View("Main/aboutus", "front");
    // }
    public function contact(): void
    {
        $myView = new View("Main/contact", "front");
    }
    
    public function designGuide(): void
    {
        $myView = new View("Main/design-guide", "front");
        $myView->assign("title", "Design Guide");
        $myView->assign("description", "Bienvenue sur le design guide de notre site");
    }
}
