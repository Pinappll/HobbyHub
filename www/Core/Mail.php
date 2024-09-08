<?php

namespace App\Core;

use App\Core\PHPMailer\PHPMailer;

class Mail
{
    private $phpmailer;
    public function __construct()
    {
        $this->phpmailer = new PHPMailer();
        $this->phpmailer->isSMTP();
        $this->phpmailer->Host = $_ENV["HOSTMAILGUN"];
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Port = $_ENV["PORTMAILGUN"];
        $this->phpmailer->Username = $_ENV["USERNAMEMAILGUN"];
        $this->phpmailer->Password = $_ENV["PASSWORDMAILGUN"];

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
            $message = $this->phpmailer->send() ? "Email bien envoyé" : "Le mail n'a pas pu être envoyé";
            return $message;
        } else {
            return "On n'a pas pu envoyer, un des mails fournie n'est pas valid";
        }
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
