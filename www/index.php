<?php
/*
 *  On récupérer l'uri exemple /login et on récupère la correspondance
 *  par exemple le controller Security et l'action login
 *  Création de l'instance de Security et on appel la method login()
 *  Si pas de correspondance alors on affichera une page 404
 */

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
        // Gérer l'erreur de lecture du fichier
        die('Erreur lors de la lecture du fichier .env');
    }
}
$dotenvPath = $_SERVER["DOCUMENT_ROOT"] . "/.env";
loadEnv($dotenvPath);
function myAutoloader(String $class): void
{
    //$class = App\Core\View
    $class = str_replace("App\\", "", $class);
    //$class = Core\View
    $class = str_replace("\\", "/", $class);
    //$class = Core/View
    if (file_exists($class . ".php")) {
        include $class . ".php";
    }
}






//Comment récupérer et nettoyer l'URI
// Exemple on doit avoir "/", "/login", "/logout", ...
if (file_exists('installer.php')) {
    
    $uri = "/installer";
}else{$uri = strtolower($_SERVER["REQUEST_URI"]);
    $uri = strtok($uri, "?");
    $uri = strlen($uri) > 1 ? rtrim($uri, "/") : $uri;}


// Récupérer le contenu du fichier routes.yaml
if (!file_exists("routes.yaml")) {
    die("Le fichier de routing n'existe pas");
}
$listOfRoutes = yaml_parse_file("routes.yaml");


//Créer une instance du bon controller
//et appeler la bonne action
//en effectuant toutes les vérifications nécessaires

/*
 * [/] => Array
        (
            [controller] => Main
            [action] => home
        )
 *
 */
function access(array $roles): bool
{
    $access = true;
    if (!empty($roles)) {
        if (isset($_SESSION["role"])) {

            if (!in_array($_SESSION['role'], $roles)) {
                $access = false;
            }
        } else {
            $access = false;
        }
    }
    return $access;
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
                            die("L'action n'existe pas dans le controller");
                        }
                    } else {
                        die("La classe du controller n'existe pas");
                    }
                } else {
                    die("Le fichier controller n'existe pas");
                }
            } else {
                die("La route ne contient pas d'action");
            }
        } else {
            die("La route ne contient pas de controller");
        }
    } else {
        die("Vous n'avez pas les droits pour accéder à cette page");
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
    }
}
