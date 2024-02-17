<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\Contact;

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

        $form = new Contact();
        $config = $form->getConfig();
        $errors = [];
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $mail = new Mail();
                $mail->sendMail("
                    <h1>Message de " . $_REQUEST["name"] . "</h1>
                    <p>" . $_REQUEST["message"] . "</p>
                ", $_REQUEST["email"], "Message de " . $_REQUEST["name"], "
                    <h1>Message envoyé</h1>
                    <p>Votre message a bien été envoyé</p>
                ");
                $message = "Votre message a bien été envoyé";
            }
        }


        $myView = new View("Main/contact", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
        $myView->assign("title", "Contact");
        $myView->assign("description", "Remplissez le formulaire ci-dessous pour nous contacter");
    }
    
    
    public function designGuide(): void
    {
        $myView = new View("Main/design-guide", "front");
        $myView->assign("title", "Design Guide");
        $myView->assign("description", "Bienvenue sur le design guide de notre site.");
    }
}
