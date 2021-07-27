<?php

namespace App\Models;

use App\Traits\Uuid;


use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'role';
    public $incrementing = false;
    protected $fillable = [
      'id',
      'RoleName',
      'CreatedDate',
      'CreatedBy',
      'LastModifiedDate',
      'LastModifiedBy',
      'Level',
    ];

    //
}
