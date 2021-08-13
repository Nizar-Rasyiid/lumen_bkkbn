<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table ='provinsi';
    protected $fillable =['KodeDepdagri','nama_provinsi','IsActive'];
    //public $incrementing = false;
    public $primaryKey = 'id_provinsi';
    public $timestamps = false;

    public function vuser()
    {
        $this->belongsTo('App\Models\V_user');
    }
}
