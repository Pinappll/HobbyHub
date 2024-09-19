<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Review as ReviewModel;
use App\Tables\ReviewTable;
use App\Forms\ReviewEdit;
use App\Models\User;


class Review
{

    public function listReviews(): void
    {

    if (isset($_GET["id_page_review"])) {
        $review = new ReviewModel();
        $data = $review->select($review->getNameDb() . "_review.*,".$review->getNameDb()."_user.firstname_user,".$review->getNameDb()."_user.lastname_user")
            ->join($review->getNameDb()."_user", $review->getNameDb() . "_review.id_user_review = " .$review->getNameDb()."_user.id")
            ->where($review->getNameDb() . "_review.id_page_review = " . $_GET["id_page_review"] . " AND " . $review->getNameDb() . "_review.status_review = 'accept'")
            ->execute();

        // Utilisation de la vue pour afficher les données des reviews
        $myView = new View("Partiel/listeReview", null);
        $myView->assign("reviews", $data);

        }
    }

    public function addReview(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_page_review']) && isset($_POST['id_user_review']) && isset($_POST['content_review'])) {

            $review = new ReviewModel();
            $review->setId_user_review($_POST['id_user_review']);
            $review->setId_page_review($_POST['id_page_review']);
            $review->setContent_review($_POST['content_review']);
            $review->setStatus_review("pending");

            // Enregistrez l'avis et vérifiez si l'enregistrement a réussi
            if ($review->save()) {
                // Envoyer un email aux administrateurs avec le contenu du commentaire
                $this->notifyAdminsOfNewReview($review);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Le commentaire a été ajouté avec succès et les administrateurs ont été notifiés.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erreur lors de l\'ajout du commentaire.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Données manquantes.'
            ]);
        }
    } 
}

// Méthode pour envoyer des emails aux administrateurs
private function notifyAdminsOfNewReview(ReviewModel $review): void
{
    $userModel = new User();
    
    // Trouver tous les admins
    $admins = $userModel->findAllAdmins();

    // Le sujet de l'email
    $subject = "Nouveau commentaire en attente de validation";

    // Récupérer les détails du commentaire
    $content_review = $review->getContent_review();
    $user_id = $review->getId_user_review();
    $page_id = $review->getId_page_review();

    // Créer le contenu de l'email avec les détails du commentaire
    $content = "Un nouveau commentaire a été posté par l'utilisateur avec l'ID : $user_id\n";
    $content .= "\nLe commentaire est en attente de validation pour la page avec l'ID : $page_id.\n\n";
    $content .= "Contenu du commentaire :\n";
    $content .= $content_review;

    // Boucle sur tous les admins et envoie un mail
    foreach ($admins as $admin) {
        $email = $admin->getEmail_user();

        // Utilisez votre classe Mail pour envoyer un email
        $mail = new \App\Core\Mail();
        $mail->sendMail([$email], $subject, $content);
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
        $myView->assign("title", "Liste des avis");

    }
    public function validate(): void
    {
        if(isset($_POST["id"])){
            $review = new ReviewModel();
            $review = $review->getOneBy(["id" => $_POST["id"]], "object");
            $review->setStatus_review("accept");
            $review->save();
            header("Location: /admin/reviews");
            exit;
        }
        
        
    }
    public function refuse(): void
    {
        if(isset($_POST["id"])){
            $review = new ReviewModel();
            $review = $review->getOneBy(["id" => $_POST["id"]], "object");
            $review->setStatus_review("refuse");
            $review->save();
            header("Location: /admin/reviews");
            exit;
        }
    }
    
}
