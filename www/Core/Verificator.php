<?php

namespace App\Core;

class Verificator
{

    public function checkForm($config, $data, &$errors): bool
    {

        //Est-ce qu'on a le bon nb d'inputs
        if (count($config["inputs"]) != count($data)) {
            var_dump(count($config["inputs"]), count($data));
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
}
