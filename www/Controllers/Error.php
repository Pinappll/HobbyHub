<?php

namespace App\Controllers;

use App\Core\View;


class Error
{

    public function page404(): void
    {
        //Pensez à modifier le code http
        http_response_code(404);
        $myView = new View("Error/404", "front");
        $myView->assign("title", "Page introuvable");
        $myView->assign("description", "La page que vous cherchez n'existe pas");
        
    }
}
