<?php

namespace App\Models;

use App\Core\DB;


class Navigation extends DB
{


    private ?int $id = null;
    protected string $name;
    protected string $link;
    protected int $position;
    protected ?int $parent_id = null;
    protected int $level;
    protected int $id_page;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getParent_id()
    {
        return $this->parent_id;
    }

    public function setParent_id($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get the value of id_page
     */
    public function getId_page()
    {
        return $this->id_page;
    }

    /**
     * Set the value of id_page
     *
     * @return  self
     */
    public function setId_page($id_page)
    {
        $this->id_page = $id_page;

        return $this;
    }

    public function getAll()
{
    return $this->findAll(); // Utilise la méthode findAll pour récupérer toutes les lignes
}
    // public function getUrlNavigationWhereIsNullOrPageId()
    // {
    //     $db = new DB();
    //     $data = $db->select()->fro
    // }
}
