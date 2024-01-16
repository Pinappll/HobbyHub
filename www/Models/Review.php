<?php

namespace App\Models;

use App\Core\DB;

class Review extends DB
{
    private ?int $id = null;
    protected int $id_user_review;
    protected int $id_recipie_review;
    protected string $title_review;
    protected string $content_review;
    protected string $status_review;

    
    public function __construct()
    {
        parent::__construct();
    }

}
