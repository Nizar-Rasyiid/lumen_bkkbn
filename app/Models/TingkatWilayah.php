<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class TingkatWilayah extends Model
{
    //use Uuid;

    protected $table = 'tingkatwilayah';
    //public $incrementing = false;
    //public $primaryKey = 'id';
    //public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //$table->increments('id');
    /* */
    protected $fillable = [
          'ID',
          'TingkatWilayah',
          'CreatedDate',
          'CreatedBy',
          'LastModifiedBy',
          'LastModifiedDate'

          //'id',
          //'no_kendaraan',

      ];


}
