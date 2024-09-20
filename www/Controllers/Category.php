<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\Category\CategoryEdit;
use App\Forms\Category\CategoryInsert;
use App\Models\Category as CategoryModel;
use App\Tables\Category as CategoryTable;

class Category
{
    public function addCategorie(): void
    {
        $form = new CategoryInsert();
        $configForm = $form->getConfig();
        $error = [];
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $verif = new Verificator();
            if ($verif->checkForm($configForm, $_POST, $error)) {
                $category = new CategoryModel();
                $category->setName_category($_POST["nameCategory"]);
                $category->save();
                $message = "La catégorie de recette a bien été ajoutée";
            }
        }
        $myView = new View("Admin/Category/add-category", "back");
        $myView->assign("configForm", $configForm);
        $myView->assign("errorsForm", $error);
        $myView->assign("message", $message);
    }
    public function showCategories(): void
    {
        $table = new CategoryTable();
        $configTable = $table->getConfig();
        $category = new CategoryModel();
        $categories = $category->findAllBy(["is_deleted" => false], );
        $myView = new View("Admin/Category/list-category", "back");
        $myView->assign("data", $categories);
        $myView->assign("configTable", $configTable);
        $myView->assign("title", "Liste des catégories");
    }
    public function deleteCategory(): void
    {
        if (!isset($_GET["id"])) {
            header("Location: /admin/category");
        }else{
            $category = new CategoryModel();
            $category = $category->getOneBy(['id' => $_GET["id"]], "object");
            if (!$category) {
                header("Location: /admin/category");
            }
            $category->setIs_deleted(true);
            $category->save();
            header("Location: /admin/category");
        }
        header("Location: /admin/category");
    }
    public function editCategory(): void
    {
        if (!isset($_GET["id"])) {
            header("Location: /admin/category");
        } else {
            $category = new CategoryModel();
            $category = $category->getOneBy(['id' => $_GET["id"]], "object");
            if (!$category) {
                header("Location: /admin/category");
            }
            $form = new CategoryEdit();
            $configForm = $form->getConfig();
            $configForm["inputs"]["nameCategory"]["value"] = $category->getName_category();
            $configForm["config"]["action"] = "/admin/category/edit?id=" . $category->getId();
            $error = [];
            $message = "";
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $verif = new Verificator();
                if ($verif->checkForm($configForm, $_POST, $error)) {
                    $category->setName_category($_POST["nameCategory"]);
                    $category->save();
                    $configForm["inputs"]["nameCategory"]["value"] = $_POST["nameCategory"];
                    $message = "La catégorie de recette a bien été modifier";
                }
            }
            $myView = new View("Admin/Category/edit-category", "back");
            $myView->assign("configForm", $configForm);
            $myView->assign("errorsForm", $error);
            $myView->assign("message", $message);
        }
    }
}
