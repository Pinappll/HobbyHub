<?php

namespace App\Core;

class Verificator
{

    public function checkForm($config, $data, &$errors): bool
    {


        //Est-ce qu'on a le bon nb d'inputs
        if (count($config["inputs"]) != count($data)) {
            die("Tentative de Hack");
        } else {
            //CSRF ???
            foreach ($config["inputs"] as $name => $input) {
                if (!isset($data[$name])) {
                    die("Tentative de Hack");
                }
                if ($name === "email" && !self::checkEmail($data[$name])) {
                    $errors[] = $config["inputs"]["email"]["error"];
                }
                if ($name === "firstname" && (strlen($data[$name]) < 2 || strlen($data[$name]) > 50)) {
                    $errors[] = $config["inputs"]["firstname"]["error"];
                }
                if ($name === "lastname" && (strlen($data[$name]) < 2 || strlen($data[$name]) > 50)) {
                    $errors[] = $config["inputs"]["lastname"]["error"];
                }
                if ($name === "password" && !$this->checkPassword($data[$name])) {
                    $errors[] = $config["inputs"]["password"]["error"];
                }
                if ($name === "passwordConf" && !$this->checkPasswordConfirmation($data["password"] ?? "", $data[$name])) {
                    $errors[] = $config["inputs"]["passwordConf"]["error"];
                }
                if ($name === "inputFileImage" && !self::checkInputFileImageType() && $input["required"] === true) {
                    $errors[] = $config["inputs"]["inputFileImage"]["error"]["type"];
                }
                if ($name === "inputFileImage" && !self::checkInputFileSize() && $input["required"] === true) {
                    $errors[] = $config["inputs"]["inputFileImage"]["error"]["size"];
                }
                if ($name === "title" && (strlen($data[$name]) < 2 || strlen($data[$name]) > 50)) {
                    $errors[] = $config["inputs"]["title"]["error"];
                }
                if ($name === "description" && (strlen($data[$name]) < 2 || strlen($data[$name]) > 50)) {
                    $errors[] = $config["inputs"]["description"]["error"];
                }
                if ($name === "select_recipe" && empty($data[$name])) {
                    $errors[] = $config["inputs"]["select_recipe"]["error"];
                }
                if ($name === "recipe" && empty($data[$name])) {
                    $errors[] = $config["inputs"]["recipe"]["error"];
                }
                if ($name === "select-url" && empty($data[$name])) {
                    $errors[] = $config["inputs"]["select-url"]["error"];
                }
                if ($name === "content_page" && empty($data[$name])) {
                    $errors[] = $config["inputs"]["content_page"]["error"];
                }
                if ($name === "title_page" && empty($data[$name])) {
                    $errors[] = $config["inputs"]["title_page"]["error"];
                }
            }
        }

        return empty($errors);
    }

    public static function checkPassword(String $password): bool
    {
        return (
            strlen($password) >= 8 &&
            preg_match("#[a-z]#", $password) &&
            preg_match("#[A-Z]#", $password) &&
            preg_match("#[0-9]#", $password)
        );
    }

    public static function checkEmail(String $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    private function checkPasswordConfirmation(String $password, String $passwordConfirmation)
    {
        return $password === $passwordConfirmation;
    }
    static public function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
    private function checkInputFileImageType()
    {

        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["inputFileImage"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        return in_array($imageFileType, array('jpg', 'jpeg', 'png', 'gif'));
    }
    private function checkInputFileSize()
    {
        return $_FILES["inputFileImage"]["size"] < 20971520 && $_FILES["inputFileImage"]["size"] >= 0; //20Mo
    }
}
