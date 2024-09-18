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
        $users = $user->getList(["is_deleted" => false]);
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $verificator = new Verificator();
        if ($verificator->checkForm($config, $_REQUEST, $errors)) {
            
            $user = new UserModel(); 
            $user->setLastname_user($_REQUEST["lastname_user"]);
            $user->setFirstname_user($_REQUEST["firstname_user"]);
            $user->setEmail_user($_REQUEST["email_user"]);
            $user->setIsverified_user(isset($_REQUEST["is_verified_user"])); 
            $user->setType_user($_REQUEST["type_user"]);
            
            
            $result = $user->save(); 

            if ($result) {
                $message = "Utilisateur ajouté avec succès.";
            } else {
                $errors[] = "Erreur lors de l'enregistrement de l'utilisateur.";
            }
        }
    }

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

    $user = $userModel->getOneBy(["id" => $id], "object"); 


    if (!$user) {
        header("Location: /admin/users");
        exit;
    }

    $myView = new View("Admin/user-edit", "back");
    $form = new UserUpdate(); 
    $config = $form->getConfig();
    $errors = [];
    $message = "";


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $verificator = new Verificator();
        if ($verificator->checkForm($config, $_REQUEST, $errors)) {
            $user->setType_user($_REQUEST["type_user"]);
            

            if ($user->save()) {
                $message = "Utilisateur modifié avec succès.";
                header("Location: /admin/users");
                exit;
            } else {
                $errors[] = "Erreur lors de la mise à jour de l'utilisateur.";
            }
        }
    }

    $myView->assign("configForm", $config);
    $myView->assign("errorsForm", $errors);
    $myView->assign("message", $message);
}


public function deleteUser(): void
{
    if (!isset($_GET["id"]) || empty($_GET["id"])) {
        header("Location: /admin/users");
        exit;
    }

    $userModel = new UserModel();

    $user = $userModel->getOneBy(["id" => $_GET["id"]], "object");

    $user = $user->setIsdeleted_user(true);

    $user->save();

    header("Location: /admin/users");
    exit;
}
    
}
