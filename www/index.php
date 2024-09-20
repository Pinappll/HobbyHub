<?php

namespace App;

use App\Controllers\Error;
use App\Models\Navigation;

spl_autoload_register("App\myAutoloader");
session_start();

function loadEnv($filePath)
{
    $file = fopen($filePath, 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line !== '' && strpos($line, '=') !== false && substr($line, 0, 1) !== '#') {
                list($key, $value) = explode('=', $line, 2);
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
        fclose($file);
    } else {
        die('Erreur lors de la lecture du fichier .env');
    }
}

$dotenvPath = $_SERVER["DOCUMENT_ROOT"] . "/.env";
loadEnv($dotenvPath);

function myAutoloader(String $class): void
{
    $class = str_replace("App\\", "", $class);
    $class = str_replace("\\", "/", $class);
    if (file_exists($class . ".php")) {
        include $class . ".php";
    }
}

// Comment récupérer et nettoyer l'URI
if (file_exists('installer.php')) {
    $uri = "/installer";
} else {
    $uri = strtolower($_SERVER["REQUEST_URI"]);
    $uri = strtok($uri, "?");
    $uri = strlen($uri) > 1 ? rtrim($uri, "/") : $uri;
}

// Récupérer le contenu du fichier routes.yaml
if (!file_exists("routes.yaml")) {
    show404();
    exit();
}

$listOfRoutes = yaml_parse_file("routes.yaml");

function access(array $roles): bool
{
    $access = true;
    if (!empty($roles)) {
        $user = new \App\Models\User();
        if (empty($_SESSION["token"])) {
            $access = false;
        }else{
            $role = $user->getOneBy(["token_user" => $_SESSION["token"]], "object")->getType_user();
        if ($role) {
            if (!in_array($role, $roles)) {
                $access = false;
            }
        } else {
            $access = false;
        };
        }
        
    }
    return $access;
}

// Fonction pour afficher la page 404 (utilisée pour les erreurs 403 et 404)
function show404()
{
    header("HTTP/1.0 404 Not Found");
    $errorController = new \App\Controllers\Error();
    $errorController->page404(); // Utilisation de la méthode `page404()` du contrôleur Error
    exit();
}

if (!empty($listOfRoutes[$uri])) {
    if (access($listOfRoutes[$uri]['roles'])) {
        if (!empty($listOfRoutes[$uri]['controller'])) {
            if (!empty($listOfRoutes[$uri]['action'])) {
                $controller = $listOfRoutes[$uri]['controller'];
                $action = $listOfRoutes[$uri]['action'];

                if (file_exists("Controllers/" . $controller . ".php")) {
                    include "Controllers/" . $controller . ".php";
                    $controller = "App\\Controllers\\" . $controller;

                    if (class_exists($controller)) {
                        $objectController = new $controller();

                        if (method_exists($objectController, $action)) {
                            $objectController->$action();
                        } else {
                            show404(); // Action non trouvée
                        }
                    } else {
                        show404(); // Classe du controller non trouvée
                    }
                } else {
                    show404(); // Fichier du controller non trouvé
                }
            } else {
                show404(); // Action manquante
            }
        } else {
            show404(); // Controller manquant
        }
    } else {
        show404(); // Accès refusé (au lieu d'une erreur 403)
    }
} else {
    include "Models/Navigation.php";
    $navigation = new Navigation();
    $navigation = $navigation->getOneBy(["link" => $uri], "object");
    if ($navigation) {
        include "Controllers/PageController.php";
        $controller = new \App\Controllers\PageController();
        $controller->readPage($navigation->getId_page());
    } else {
        show404(); // URI non trouvée
    }
}
