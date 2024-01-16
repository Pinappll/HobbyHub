<?php

namespace App\Models;

use App\Core\DB;

class Setting extends DB
{
    private ?int $id = null;
    protected string $name_setting;
    protected string $slogan_setting;
    protected string $logo_url_setting;
    protected string $color_setting;

    
    public function __construct()
    {
        parent::__construct();
    }

}
