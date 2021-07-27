<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class WebSetting extends Model
{
    //
    use Uuid;

    protected $table = 'tm_web_settings';
    public $incrementing = false;
}
