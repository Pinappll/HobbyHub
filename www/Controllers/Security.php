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



class Security
{
    public function login(): void
{

    if (isset($_SESSION['user_id'])) {
        header("Location: /");
    } else {

    $form = new UserLogin();
    $config = $form->getConfig();
    $errors = [];
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $verificator = new Verificator();
        if ($verificator->checkForm($config, $_REQUEST, $errors)) {
            $user = new User();
            $user = $user->getOneBy(["email_user" => $_REQUEST["email"]], "object");

            if (empty($user)) {
                $errors[] = "Le login ou le mot de passe est incorrect";
            } else {
                // Vérification si le compte est supprimé (soft delete)
                if ($user->getIsDeleted()) {
                    $errors[] = "Votre compte a été désactivé. Veuillez contacter l'administrateur.";
                } else {
                    if ($user->getIsverified_user()) {
                        $password_hash_from_db = $user->getPassword_user();

                        if (password_verify($_REQUEST["password"], $password_hash_from_db)) {
                            $_SESSION['user_id'] = $user->getId();
                            $_SESSION['username'] = $user->__toString();
                            $_SESSION["role"] = $user->getType_user();
                            $_SESSION["token"] = $user->getToken_user();
                            $message = "Connexion réussie";
                            header("Location: /");
                        } else {
                            $errors[] = "Le login ou le mot de passe est incorrect";
                        }
                    } else {
                        $errors[] = "Veuillez vérifier votre compte.";
                    }
                }
            }
        }
    }
    $myView = new View("Security/login", "front");
    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errors);
    $myView->assign("message", $message);
    $myView->assign("title", "Connexion");
    $myView->assign("description", "Veuillez-vous connecter pour accéder à votre compte.");
}
}


    public function logout(): void
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /");
    }

    public function register(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
        }else{
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
        $myView = new View("Security/login", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
        $myView->assign("title", "Inscription");
        $myView->assign("description", "Veuillez-vous inscrire pour porfiter de nos services");
    }
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
    if (isset($_SESSION['user_id'])) {
        header("Location: /");
    } else {
        $form = new UserForgetPassword();
        $config = $form->getConfig();
        $errors = [];
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
            $verificator = new Verificator();
            if ($verificator->checkForm($config, $_REQUEST, $errors)) {
                $user = new User();
                $user = $user->getOneBy(["email_user" => $_REQUEST["email"]], "object");

                if ($user) {
                    // Utiliser le token existant ou en générer un nouveau si nécessaire
                    if (!$user->getToken_user()) {
                        $token = $verificator->generateToken();
                        $user->setToken_user($token);
                    } else {
                        // Si le token existe déjà, on l'utilise sans en créer un nouveau
                        $token = $user->getToken_user();
                    }

                    if ($user->save()) {
                        // Envoyer un email avec le lien de réinitialisation
                        $mail = new Mail();
                        $subject = "Réinitialisation du mot de passe";
                        $content = 'Cliquez sur le lien suivant pour réinitialiser votre mot de passe : 
                                    <a href="http://localhost/change-password?token=' . $token . '">Réinitialiser le mot de passe</a>';
                        $message = $mail->sendMail([$user->getEmail_user()], $subject, $content);
                    } else {
                        $errors[] = "Erreur lors de l'envoi de l'e-mail.";
                    }
                } else {
                    $errors[] = "Adresse e-mail non enregistrée.";
                }
            }
        }

        $myView = new View("Security/password-forgot", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);
        $myView->assign("title", "Mot de passe oublié");
    }
}




public function changePassword()
{
    $token = $_GET["token"] ?? "";
    $form = new UserChangePassword();
    $config = $form->getConfig(["token" => $token]);
    $errors = [];
    $message = "";

    $verificator = new Verificator();
    if ($_SERVER["REQUEST_METHOD"] == $config["config"]["method"]) {
        if ($verificator->checkForm($config, $_REQUEST, $errors)) {
            $user = new User();
            $user = $user->getOneBy(["token_user" => $_REQUEST["token"]], "object");
            if ($user) {
                // Met à jour le mot de passe
                $user->setPassword_user($_REQUEST["password"]);
                if ($user->save()) {
                    $message = "Mot de passe modifié avec succès. Vous pouvez vous connecter.";
                } else {
                    $errors[] = "Erreur lors de la modification du mot de passe.";
                }
            } else {
                $errors[] = "Le token est invalide ou l'utilisateur n'existe pas.";
            }
        }
    }

    $myView = new View("Security/change-password", "front");
    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errors);
    $myView->assign("message", $message);
}

}
