<?php

namespace App\Controllers;

class Error
{

    public function page404(): void
    {
        //Pensez à modifier le code http
        http_response_code(404);
        echo "Page 404";
    }
}
