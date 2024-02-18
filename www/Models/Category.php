<?php

namespace App\Models;

use App\Core\DB;

class Category extends DB
{
    private ?int $id = null;
    protected string $name_category;
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
     * Get the value of name_category
     */
    public function getName_category()
    {
        return $this->name_category;
    }

    /**
     * Set the value of name_category
     *
     * @return  self
     */
    public function setName_category($name_category)
    {
        $this->name_category = $name_category;

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
