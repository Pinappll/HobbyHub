<?php

namespace  App\Core;

abstract class Utils
{
    static public function checkValidationRequest(array $arrayInput, array $config)
    {
        $errors = [];
        $password = "";
        $passwordConf = "";
        foreach ($arrayInput as $key => $input) {
            switch (true) {
                case in_array($key, ["firstname", "lastname"]) && (strlen($input) < 2 || strlen($input) > 50):
                    $errors[] = $config["inputs"][$key]["error"];
                    break;
                case $key === "email" && !filter_var($input, FILTER_VALIDATE_EMAIL):
                    $errors[] = $config["inputs"]["email"]["error"];
                    break;
                case $key === "password" && !preg_match("/^(?=.*[a-z])(?=.*\d).{8,}$/", $input):
                    $errors[] = $config["inputs"]["password"]["error"];

                    break;
                case $key === "passwordConf":
                    $passwordConf = $input;
                    $password = $arrayInput["password"];
                    break;
            }
        }
        if (array_key_exists("passwordConf", $arrayInput) && ($password !== $passwordConf || $passwordConf === "")) {
            $errors[] = $config["inputs"]["passwordConf"]["error"];
        }
        return $errors;
    }
    static public function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}
