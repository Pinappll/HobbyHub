<?php

namespace App\Models;

use App\Core\DB;

class Review extends DB
{
    private ?int $id = null;
    protected int $id_user_review;
    protected int $id_page_review;
    protected string $content_review;
    protected string $status_review="pending";

    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the value of status_review
     */ 
    public function getStatus_review()
    {
        return $this->status_review;
    }

    /**
     * Set the value of status_review
     *
     * @return  self
     */ 
    public function setStatus_review($status_review)
    {
        $this->status_review = $status_review;

        return $this;
    }

    /**
     * Get the value of content_review
     */ 
    public function getContent_review()
    {
        return $this->content_review;
    }

    /**
     * Set the value of content_review
     *
     * @return  self
     */ 
    public function setContent_review($content_review)
    {
        $this->content_review = $content_review;

        return $this;
    }


    /**
     * Get the value of id_page_review
     */ 
    public function getId_page_review()
    {
        return $this->id_page_review;
    }

    /**
     * Set the value of id_page_review
     *
     * @return  self
     */ 
    public function setId_page_review($id_page_review)
    {
        $this->id_page_review = $id_page_review;

        return $this;
    }

    /**
     * Get the value of id_user_review
     */ 
    public function getId_user_review()
    {
        return $this->id_user_review;
    }

    /**
     * Set the value of id_user_review
     *
     * @return  self
     */ 
    public function setId_user_review($id_user_review)
    {
        $this->id_user_review = $id_user_review;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    public function countReviews(): int
    {
        return $this->countRows();
    }
}
