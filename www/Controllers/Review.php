<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Review as ReviewModel;
use App\Tables\ReviewTable;


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


    public function readReview(): void
    {
        $myView = new View("Review/readReview", "front");
    }
    
    public function deleteReview(): void
    {
        $myView = new View("Review/deleteReview", "front");
    }

    public function showReviews(): void
    {
        $myView = new View("Admin/reviews", "back");
        $table = new ReviewTable();
        $configTable = $table->getConfig();
        $myView->assign("configTable", $configTable);
        $review = new ReviewModel();
        $data = $review->findAll();
        $myView->assign("data", $data);
        
    }
}
