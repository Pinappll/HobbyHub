<?php

namespace App\Models;

use App\Core\DB;

class Recipie extends DB
{
    private ?int $id = null;
    protected int $id_user_recipie;
    protected string $title_recipie;
    protected string $ingredients_recipie;
    protected string $instructions_recipie;
    protected string $image_url_recipie;

    
    public function __construct()
    {
        parent::__construct();
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

    /**
     * Get the value of id_user_recipie
     */ 
    public function getId_user_recipie()
    {
        return $this->id_user_recipie;
    }

    /**
     * Set the value of id_user_recipie
     *
     * @return  self
     */ 
    public function setId_user_recipie($id_user_recipie)
    {
        $this->id_user_recipie = $id_user_recipie;

        return $this;
    }

    /**
     * Get the value of title_recipie
     */ 
    public function getTitle_recipie()
    {
        return $this->title_recipie;
    }

    /**
     * Set the value of title_recipie
     *
     * @return  self
     */ 
    public function setTitle_recipie($title_recipie)
    {
        $this->title_recipie = $title_recipie;

        return $this;
    }

    /**
     * Get the value of ingredients_recipie
     */ 
    public function getIngredients_recipie()
    {
        return $this->ingredients_recipie;
    }

    /**
     * Set the value of ingredients_recipie
     *
     * @return  self
     */ 
    public function setIngredients_recipie($ingredients_recipie)
    {
        $this->ingredients_recipie = $ingredients_recipie;

        return $this;
    }

    /**
     * Get the value of instructions_recipie
     */ 
    public function getInstructions_recipie()
    {
        return $this->instructions_recipie;
    }

    /**
     * Set the value of instructions_recipie
     *
     * @return  self
     */ 
    public function setInstructions_recipie($instructions_recipie)
    {
        $this->instructions_recipie = $instructions_recipie;

        return $this;
    }

    /**
     * Get the value of image_url_recipie
     */ 
    public function getImage_url_recipie()
    {
        return $this->image_url_recipie;
    }

    /**
     * Set the value of image_url_recipie
     *
     * @return  self
     */ 
    public function setImage_url_recipie($image_url_recipie)
    {
        $this->image_url_recipie = $image_url_recipie;

        return $this;
    }
}
