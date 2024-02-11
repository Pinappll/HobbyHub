<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    private $phpmailer;
    public function __construct()
    {


        $this->phpmailer = new PHPMailer();
        $this->phpmailer->isSMTP();
        $this->phpmailer->Host = $_ENV["HOSTMAILTRAP"];
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Port = $_ENV["PORTMAILTRAP"];
        $this->phpmailer->Username = $_ENV["USERNAMEMAILTRAP"];
        $this->phpmailer->Password = $_ENV["PASSWORDMAILTRAP"];
        $this->phpmailer->CharSet = "utf-8";
        $this->phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;
        var_dump($this->phpmailer);

        // $this->phpmailer = new PHPMailer();
        // $this->phpmailer->isSMTP();
        // $this->phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        // var_dump($this->phpmailer);
        // $this->phpmailer->SMTPAuth = true;
        // $this->phpmailer->Port = 2525;
        // $this->phpmailer->Username =
        //     'db128c125df09d';
        // $this->phpmailer->Password =
        //     'ab4b6f5ce89761';
        // $this->phpmailer->CharSet = "utf-8";
        // $this->phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;
        // var_dump($phpmailer->Host, $this->phpmailer->Host);
    }
    public function sendMail(array $arrayMail, string $subject, string $contentMail)
    {
        if ($this->arrayIsValid($arrayMail)) {
            foreach ($arrayMail as $mail) {
                $this->phpmailer->addAddress($mail);
            }
            $this->phpmailer->CharSet = "utf-8";
            $this->phpmailer->setFrom("no-reply@easyCook.fr");
            $this->phpmailer->isHTML(true);
            $this->phpmailer->Subject = $subject;
            $this->phpmailer->Body = $contentMail;
            $this->phpmailer->send();
            return "Email bien envoyé";
        } else {
            return "On n'a pas pu envoyer";
        }
        // $phpmailer = new PHPMailer();
        // $phpmailer->isSMTP();
        // $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        // $phpmailer->SMTPAuth = true;
        // $phpmailer->Port = 2525;
        // $phpmailer->Username = 'db128c125df09d'; //changer
        // $phpmailer->Password = 'ab4b6f5ce89761'; //changer

        // $phpmailer->CharSet = "utf-8";
        // $phpmailer->addAddress("ludovic93mak@gmail.com");
        // $phpmailer->setFrom("no-reply@easyCook.fr");
        // $phpmailer->isHTML(true);
        // $phpmailer->Subject = "Vérification du compte";
        // $phpmailer->Body    = 'Cliquez sur le lien suivant pour activer votre compte : <a href="http://localhost/change-password?token=">Activer</a>';
        // $phpmailer->send();
        // $message = 'Un e-mail d\'activation a été envoyé à votre adresse.';
    }
    private function arrayIsValid(array $arrayMail): bool
    {

        foreach ($arrayMail as $mail) {

            if (!Verificator::checkEmail($mail)) {
                return false;
            }
        }
        return true;
    }
}
