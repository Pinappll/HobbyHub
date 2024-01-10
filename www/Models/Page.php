<?php

namespace App\Models;

use App\Core\DB;

class Page extends DB
{
    private ?int $id = null;
    protected int $id_restaurant_page;
    protected string $title_page;
    protected string $content_page;
    protected string $markup_meta_pages;

    
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
     * Get the value of id_restaurant_page
     */ 
    public function getId_restaurant_page()
    {
        return $this->id_restaurant_page;
    }

    /**
     * Set the value of id_restaurant_page
     *
     * @return  self
     */ 
    public function setId_restaurant_page($id_restaurant_page)
    {
        $this->id_restaurant_page = $id_restaurant_page;

        return $this;
    }

    /**
     * Get the value of title_page
     */ 
    public function getTitle_page()
    {
        return $this->title_page;
    }

    /**
     * Set the value of title_page
     *
     * @return  self
     */ 
    public function setTitle_page($title_page)
    {
        $this->title_page = $title_page;

        return $this;
    }

    /**
     * Get the value of content_page
     */ 
    public function getContent_page()
    {
        return $this->content_page;
    }

    /**
     * Set the value of content_page
     *
     * @return  self
     */ 
    public function setContent_page($content_page)
    {
        $this->content_page = $content_page;

        return $this;
    }

    /**
     * Get the value of markup_meta_pages
     */ 
    public function getMarkup_meta_pages()
    {
        return $this->markup_meta_pages;
    }

    /**
     * Set the value of markup_meta_pages
     *
     * @return  self
     */ 
    public function setMarkup_meta_pages($markup_meta_pages)
    {
        $this->markup_meta_pages = $markup_meta_pages;

        return $this;
    }
}
