<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\UserInsert;
use App\Forms\UserLogin;
use App\Models\User;
use App\Core\Utils;


class Security
{
    public function login(): void
    {

        $formLogin = new UserLogin();
        $configLogin = $formLogin->getConfig();

        $formRegister = new UserInsert();
        $configRegister = $formRegister->getConfig();

        $myView = new View("Security/login", "front");
        $myView->assign("configFormLogin", $configLogin);
        $myView->assign("configFormRegister", $configRegister);
    }

    public function logout(): void
    {
        echo "Ma page de déconnexion";
    }

    public function register(): void
    {
        $form = new UserInsert();
        $config = $form->getConfig();
        $errors = [];
        $myView = new View("Security/register", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $firstname = $_POST['firstname'] ?? "";
            $lastname = $_POST['lastname'] ?? "";
            $email = $_POST['email'] ?? "";
            $password = $_POST['password'] ?? "";
            $passwordConf = $_POST['passwordConf'] ?? "";

            $errors = Utils::checkValidationRequest(
                [
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "email" => $email,
                    "password" => $password,
                    "passwordConf" => $passwordConf,
                ],
                $config
            );
            $myView->assign("errorsForm", $errors);
            if (empty($errors)) {
                $user = new User();
                $user->setFirstname_user($_POST['firstname']);
                $user->setLastname_user($_POST['lastname']);
                $user->setEmail_user($_POST['email']);
                $user->setPassword_user($_POST['password']);
                $user->save();
            }
        }
    }
}
