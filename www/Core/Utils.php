<?php

namespace  App\Core;

abstract class Utils
{
    static public function checkValidationRequest(array $arrayInput, array $config)
    {
        $errors = [];
        $password = "";
        $passwordConf = "";
        var_dump($arrayInput);
        foreach ($arrayInput as $key => $input) {
            switch ($key) {
                case "firstname":
                    if (strlen($input) < 2 || strlen($input) > 50) {
                        $errors[] = $config["inputs"]["firstname"]["error"];
                    }
                    break;
                case "lastname":
                    if (strlen($input) < 2 || strlen($input) > 50) {
                        $errors[] = $config["inputs"]["lastname"]["error"];
                    }
                    break;
                case "email":
                    if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = $config["inputs"]["email"]["error"];
                    }
                    break;
                case "password":
                    if (!preg_match("/^(?=.*[a-z])(?=.*\d).{8,}$/", $input)) {
                        $errors[] = $config["inputs"]["password"]["error"];
                    }
                    $password = $input;
                    break;
                case "passwordConf":
                    $passwordConf = $input;
                    break;
            }
        }
        if (array_key_exists("passwordConf", $arrayInput) && ($password !== $passwordConf || $passwordConf === "")) {
            $errors[] = $config["inputs"]["passwordConf"]["error"];
        }
        return $errors;
    }
}
