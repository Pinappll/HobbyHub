<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\User\UserInsert;
use App\Forms\User\UserUpdate;
use App\Models\User as UserModel;
use App\Tables\UserTable;

class User
{


    public function showUsers(): void
    {
        $table = new UserTable();
        $configTable = $table->getConfig();
        $user = new UserModel();
        $users = $user->getList();
        $myView = new View("Admin/users", "back");
        $myView->assign("data", $users);
        $myView->assign("configTable", $configTable);
        $myView->assign("title", "Liste des utilisateurs");
    }

    public function addUser(): void
{
    $myView = new View("Admin/user-add", "back");
    $form = new UserInsert(); 
    $config = $form->getConfig();
    $errors = [];
    $message = "";

    // Créer la liste des rôles utilisateur (comme dans editUser)
    $role = [
        ["id" => "viewer", "name" => "viewer"], 
        ["id" => "admin", "name" => "admin"], 
        ["id" => "chef", "name" => "chef"]
    ];
    $config["inputs"]["type_user"]["option"] = $role;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $verificator = new Verificator();
        if ($verificator->checkForm($config, $_REQUEST, $errors)) {
            
            $user = new UserModel(); 
            $user->setLastname_user($_REQUEST["lastname_user"]);
            $user->setFirstname_user($_REQUEST["firstname_user"]);
            $user->setEmail_user($_REQUEST["email_user"]);
            $user->setIsverified_user(isset($_REQUEST["is_verified_user"]));
            $user->setPassword_user($_REQUEST["password_user"]); 
            $user->setType_user($_REQUEST["type_user"]);
            $user->setToken_user(bin2hex(random_bytes(16)));
            
            $result = $user->save(); 

            if ($result) {
                $message = "Utilisateur ajouté avec succès.";
            } else {
                $errors[] = "Erreur lors de l'enregistrement de l'utilisateur.";
            }
        }
    }

    // Assigner les valeurs du formulaire, erreurs et message à la vue
    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errors);
    $myView->assign("message", $message);
}


public function editUser(): void
{
    if (!isset($_GET["id"]) || empty($_GET["id"])) {
        header("Location: /admin/users");
        exit;
    }

    $id = $_GET["id"];
    $userModel = new UserModel();

    // Récupérer l'utilisateur par ID
    $user = $userModel->getOneBy(["id" => $id], "object");
    

    if (!$user) {
        header("Location: /admin/users");
        exit;
    }

    $myView = new View("Admin/user-edit", "back");
    $form = new UserUpdate(); 
    $config = $form->getConfig($user);  // Passer les données utilisateur au formulaire
    $errors = [];
    $message = "";
    $role = [             ["id" => "viewer", "name" => "viewer"],             ["id" => "admin", "name" => "admin"],             ["id" => "chef", "name" => "chef"] ];
    $config["inputs"]["type_user"]["option"] = $role;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_REQUEST["type_user"])) {
            $_REQUEST["type_user"] = [];
        }
        $verificator = new Verificator();
        if ($verificator->checkForm($config, $_POST, $errors)) {
            // Mettre à jour les champs avec les nouvelles données soumises
            $user->setLastname_user($_POST["lastname_user"]);
            $user->setFirstname_user($_POST["firstname_user"]);
            $user->setEmail_user($_POST["email_user"]);
            $user->setType_user($_REQUEST["type_user"] == [] ? "admin" : $_REQUEST["type_user"]);
            $user->setIsverified_user(isset($_POST["is_verified_user"]));
            // Vérifier si un mot de passe a été soumis
            if (!empty($_POST["password_user"])) {
                $user->setPassword_user($_POST["password_user"]);
            }

            // Générer un token s'il est nécessaire
            if (empty($user->getToken_user())) {
                $user->setToken_user(bin2hex(random_bytes(16)));
            }

            if ($user->save()) {
                $message = "Utilisateur modifié avec succès.";
                header("Location: /admin/users");
                exit;
            } else {
                $errors[] = "Erreur lors de la mise à jour de l'utilisateur.";
            }
        }
    }

    // Assigner les valeurs du formulaire et les erreurs à la vue
    $myView->assign("configForm", $config);  // Assigner le formulaire à la vue
    $myView->assign("errorsForm", $errors);  // Assigner les erreurs du formulaire à la vue
    $myView->assign("message", $message);    // Assigner un message à la vue
}



public function deleteUser(): void
    {
        // Vérifier si l'ID utilisateur est présent
        if (!isset($_GET["id"]) || empty($_GET["id"])) {
            header("Location: /admin/users");
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getOneBy(["id" => $_GET["id"]], "object");

        if (!$user) {
            header("Location: /admin/users");
            exit;
        }

        // Appel de la méthode delete du modèle (soft delete)
        $user->delete();

        // Redirection après la suppression
        header("Location: /admin/users");
        exit;
    }

// anonymizeUser method
public function anonymizeUser(): void
{
    // Vérifier si l'ID utilisateur est présent
    if (!isset($_GET["id"]) || empty($_GET["id"])) {
        header("Location: /admin/users");
        exit;
    }

    $userModel = new UserModel();
    $user = $userModel->getOneBy(["id" => $_GET["id"]], "object");

    if (!$user) {
        header("Location: /admin/users");
        exit;
    }

    // Appel de la méthode anonymize du modèle
    $user->anonymize();

    // Redirection après l'anonymisation
    header("Location: /admin/users");
    exit;
}


 
    
}
