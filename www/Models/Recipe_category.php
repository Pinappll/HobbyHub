<?php

namespace App\Models;

use App\Core\DB;

class Recipe_category extends DB
{
    private ?int $id = null;
    protected int $id_recipe_category;
    protected int $id_category;

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
     * Get the value of id_recipe_category
     */
    public function getId_recipe_category()
    {
        return $this->id_recipe_category;
    }

    /**
     * Set the value of id_recipe_category
     *
     * @return  self
     */
    public function setId_recipe_category($id_recipe_category)
    {
        $this->id_recipe_category = $id_recipe_category;

        return $this;
    }

    /**
     * Get the value of id_category
     */
    public function getId_category()
    {
        return $this->id_category;
    }

    /**
     * Set the value of id_category
     *
     * @return  self
     */
    public function setId_category($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }
}
