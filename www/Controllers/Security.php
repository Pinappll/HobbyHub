<?php

namespace App\Controllers;

use App\Core\Mail;
use App\Core\View;
use App\Forms\UserInsert;
use App\Forms\UserLogin;
use App\Models\User;
use App\Core\Verificator;
use App\Forms\UserChangePassword;
use App\Forms\UserForgetPassword;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

class Security
{
    public function login(): void
    {
        $form = new UserLogin();
        $config = $form->getConfig();
        $errors = [];
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $user = new User();
                $row = $user->getOneBy(["email_user" => $_REQUEST["email"]]);
                if ($row["isverified_user"]) {

                    if ($row) {
                        $password_hash_from_db = $row['password_user'];

                        if (password_verify($_REQUEST["password"], $password_hash_from_db)) {
                            $_SESSION['user_id'] = $row["id"];
                            $_SESSION['username'] = $row["lastname_user"] . " " . $row["firstname_user"];
                            $message = "Connexion réussie";
                        } else {
                            $errors[] = "le login ou le mot de passe est incorrect";
                        }
                    } else {
                        $errors[] = "le login ou le mot de passe est incorrect";
                    }
                } else {
                    $errors[] = "Veuillez vérifier votre compte";
                }
            }
        }
        $myView = new View("Security/login", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    public function logout(): void
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /");
    }

    public function register(): void
    {
        $form = new UserInsert();
        $config = $form->getConfig();
        $errors = [];
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
            // Ensuite est-ce que les données sont OK
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $activation_token = $verificator->generateToken();
                $user = new User();
                $isExistEmail = !empty($user->getOneBy(["email_user" => $_REQUEST["email"]]));
                if ($isExistEmail) {
                    $errors = ["Cette email est déjà utilisé"];
                } else {
                    $user->setFirstname_user($_REQUEST["firstname"]);
                    $user->setLastname_user($_REQUEST["lastname"]);
                    $user->setEmail_user($_REQUEST["email"]);
                    $user->setPassword_user($_REQUEST["password"]);
                    $user->setToken_user($activation_token);
                    $user->save();
                    $mail = new Mail();
                    $subject = "Vérification du compte";
                    $content = 'Cliquez sur le lien suivant pour activer votre compte : <a href="http://localhost/enable-account?token=' . $activation_token . '">Activer</a>';
                    $message = $mail->sendMail([$user->getEmail_user()], $subject, $content);
                }
            }
        }
        $myView = new View("Security/register", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    public function enableAccount()
    {

        $myView = new View("Security/enable-account", "front");
        $token = $_GET["token"];
        $user = new User;
        $user = $user->getOneBy(["token_user" => $token]);
        $message = "";
        if (!empty($user)) {
            $updateUser = new User;
            $user = $updateUser->populate($user["id"]);
            $user->setIsverified_user('true');
            $user->save();
            $message = "Activation du compte avec succès";
        } else {
            $message = "Erreur sur l'activation du compte";
        }
        $myView->assign("message", $message);
    }

    public function passwordForgot()
    {
        $form = new UserForgetPassword();
        $config = $form->getConfig();
        $errors = array();
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $user = new User();
                $user = $user->getOneBy(["email_user" => $_REQUEST["email"]], "object");
                if ($user) {
                    $token = $verificator->generateToken();
                    $user->setToken_user($token);
                    if ($user->save()) {
                        $mail = new Mail();
                        $subject = "Vérification du compte";
                        $content = 'Cliquez sur le lien suivant pour activer votre compte : <a href="http://localhost/change-password?token=' . $token . '">Activer</a>';
                        $message = $mail->sendMail([$user->getEmail_user()], $subject, $content);
                    } else {
                        $errors = array("Email non envoyé");
                    }
                } else {
                    $errors = array("Email non enregistrer");
                }
            }
        }
        $myView = new View("Security/password-forgot", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }

    public function changePassword()
    {
        $token = $_GET["token"] ?? "";
        $form = new UserChangePassword();
        $config = $form->getConfig(["token" => $token]);
        $errors = array();
        $message = "";
        $verificator = new Verificator();
        if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $user = new User();
                $user = $user->getOneBy(["token_user" => $_REQUEST["token"]], "object");
                if ($user) {
                    $user->setPassword_user($_REQUEST["password"]);
                    $user->save() && $message = "Mot de passe modifié";
                } else {
                    $errors = ("Votre compte n'a pas pu être trouver");
                }
            }
        }
        $myView = new View("Security/password-forgot", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
    }
}
