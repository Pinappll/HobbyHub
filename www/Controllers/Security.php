<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\UserInsert;
use App\Forms\UserLogin;
use App\Models\User;
use App\Core\Utils;

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
        $myView = new View("Security/login", "front");
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'] ?? "";
            $password_from_user = $_POST['password'] ?? "";
            $user = new User();
            $row = $user->getOneBy(["email_user" => $email]);
            if ($row["isverified_user"]) {

                if ($row) {
                    $password_hash_from_db = $row['password_user'];

                    if (password_verify($password_from_user, $password_hash_from_db)) {
                        session_start();
                        $_SESSION['user_id'] = $row["id"];
                        $_SESSION['username'] = $row["lastname_user"] + " " + $row["firstname_user"];
                    } else {
                        $errors[] = "le login ou le mot de passe est incorrect";
                    }
                } else {
                    $errors[] = "le login ou le mot de passe est incorrect";
                }
            } else {
                $errors[] = "Veuillez vérifier votre compte";
            }

            $myView->assign("errorsForm", $errors);
        }
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

                $activation_token = Utils::generateToken();
                $user = new User();
                $isExistEmail = !empty($user->getOneBy(["email_user" => $email]));
                if ($isExistEmail) {
                    $errors = ["Ce mail est déjà utilisé"];
                    $myView->assign("errorsForm", $errors);
                } else {
                    $user->setFirstname_user($firstname);
                    $user->setLastname_user($lastname);
                    $user->setEmail_user($email);
                    $user->setPassword_user($password);
                    $user->setToken_user($activation_token);
                    $user->save();

                    try {
                        $phpmailer = new PHPMailer();
                        $phpmailer->isSMTP();
                        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                        $phpmailer->SMTPAuth = true;
                        $phpmailer->Port = 2525;
                        $phpmailer->Username = 'db128c125df09d'; //changer
                        $phpmailer->Password = 'ab4b6f5ce89761'; //changer

                        $phpmailer->CharSet = "utf-8";
                        $phpmailer->addAddress($user->getEmail_user());
                        $phpmailer->setFrom("no-reply@easyCook.fr");
                        $phpmailer->isHTML(true);
                        $phpmailer->Subject = "Vérification du compte";
                        $phpmailer->Body    = 'Cliquez sur le lien suivant pour activer votre compte : <a href="http://localhost/enable-account?token=' . $activation_token . '">Activer</a>';
                        $phpmailer->send();
                        echo 'Un e-mail d\'activation a été envoyé à votre adresse.';
                    } catch (Exception) {
                        echo "L'envoi de l'e-mail a échoué. Erreur : {$phpmailer->ErrorInfo}";
                    }
                }
            }
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
}
