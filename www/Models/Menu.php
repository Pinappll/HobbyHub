<?php

namespace App\Models;

use App\Core\DB;

class Menu extends DB
{
    private ?int $id = null;
    protected string $title_menu;
    protected string $description_menu;
    protected int $id_restaurant_menu;
    protected int $id_recipie_menu;
    protected bool $is_deleted;

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
     * Get the value of id_restaurant_menu
     */
    public function getId_restaurant_menu()
    {
        return $this->id_restaurant_menu;
    }

    /**
     * Set the value of id_restaurant_menu
     *
     * @return  self
     */
    public function setId_restaurant_menu($id_restaurant_menu)
    {
        $this->id_restaurant_menu = $id_restaurant_menu;

        return $this;
    }

    /**
     * Get the value of id_recipie_menu
     */
    public function getId_recipie_menu()
    {
        return $this->id_recipie_menu;
    }

    /**
     * Set the value of id_recipie_menu
     *
     * @return  self
     */
    public function setId_recipie_menu($id_recipie_menu)
    {
        $this->id_recipie_menu = $id_recipie_menu;

        return $this;
    }

    /**
     * Get the value of title_menu
     */
    public function getTitle_menu()
    {
        return $this->title_menu;
    }

    /**
     * Set the value of title_menu
     *
     * @return  self
     */
    public function setTitle_menu($title_menu)
    {
        $this->title_menu = $title_menu;

        return $this;
    }

    /**
     * Get the value of description_menu
     */
    public function getDescription_menu()
    {
        return $this->description_menu;
    }

    /**
     * Set the value of description_menu
     *
     * @return  self
     */
    public function setDescription_menu($description_menu)
    {
        $this->description_menu = $description_menu;

        return $this;
    }

    /**
     * Get the value of is_deleted
     */
    public function getIs_deleted()
    {
        return $this->is_deleted;
    }

    /**
     * Set the value of is_deleted
     *
     * @return  self
     */
    public function setIs_deleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }
}
