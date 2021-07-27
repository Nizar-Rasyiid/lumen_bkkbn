<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table     = 'Kabupaten';
    //public $incrementing = false;
    public $primaryKey = 'id_provinsi';
    //public $timestamps = false;
    public function KabupatenKotaProvinsiID()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }
}
