<?php

namespace App\Models;

use App\Core\DB;

class Page extends DB
{
    private ?int $id = null;
    protected string $title_page;
    protected string $content_page;
    protected bool $is_deleted;

    
    // Je veux que le contenu de la page soit en json



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

    public function countPages(): int
    {
        return $this->countRows();
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
