<?php

namespace App\Controllers;

use App\Core\View;

class Review
{

    public function createReview(): void
    {
        $myView = new View("Review/createReview", "front");
    }
    public function readReview(): void
    {
        $myView = new View("Review/readReview", "front");
    }
    public function updateReview(): void
    {
        $myView = new View("Review/readReview", "front");
    }
    public function deleteReview(): void
    {
        $myView = new View("Review/deleteReview", "front");
    }
}
