<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Review as ReviewModel;
use App\Tables\ReviewTable;
use App\Forms\ReviewEdit;


class Review
{

    public function addReview(): void
    {

        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_recipie_review']) && isset($_POST['title_review']) && isset($_POST['content_review'])) {

                $review = new ReviewModel();
                $review->setId_user_review($_SESSION['id']);
                $review->setId_recipie_review($_POST['id_recipie_review']);
                $review->setTitle_review($_POST['title_review']);
                $review->setContent_review($_POST['content_review']);
                $review->save();
            }
        }
         else {
            echo "Erreur lors de l'ajout de l'avis";
        }


    }


    public function editReview(): void
    {
        $myView = new View("Review/editReview", "back");
        $form = new ReviewEdit();
        $config = $form->getConfig($_GET);
        $errors = [];
        $message = "";

        if (!isset($_GET["id_review"]) || empty($_GET["id_review"])) {
            header("Location: /admin/reviews");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_review']) && isset($_POST['status_review'])) {
                $review = new ReviewModel();
                $review = $review->getOneBy(["id" => $_POST['id_review']], "object");
                $review->setStatus_review($_POST['status_review']);
                $review->save();
                $myView = new View("Admin/reviews", "back");
                $myView->assign("message", "L' avis a bien été mis à jour");
            }
        }

        
        $myView->assign("configForm", $config);
        $myView->assign("errorsForm", $errors);
        $myView->assign("message", $message);


    }
    
    

    public function showReviews(): void
    {
        $myView = new View("Admin/reviews", "back");
        $table = new ReviewTable();
        $configTable = $table->getConfig();
        $myView->assign("configTable", $configTable);
        $review = new ReviewModel();
        
        $myView->assign("data", $review->getList());

    }
}
