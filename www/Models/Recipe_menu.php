<?php

namespace App\Models;

use App\Core\DB;

class Recipe_menu extends DB
{
    private ?int $id = null;
    protected int $id_recipe;
    protected int $id_menu;

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
     * Get the value of id_recipe
     */
    public function getId_recipe()
    {
        return $this->id_recipe;
    }

    /**
     * Set the value of id_recipe
     *
     * @return  self
     */
    public function setId_recipe($id_recipe)
    {
        $this->id_recipe = $id_recipe;

        return $this;
    }

    /**
     * Get the value of id_menu
     */
    public function getId_menu()
    {
        return $this->id_menu;
    }

    /**
     * Set the value of id_menu
     *
     * @return  self
     */
    public function setId_menu($id_menu)
    {
        $this->id_menu = $id_menu;

        return $this;
    }
}
