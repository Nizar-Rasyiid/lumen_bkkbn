<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table     = 'kabupaten';
    protected $fillable     = ['id_provinsi','nama_kabupaten','KodeDepdagri','IsActive'];
    //public $incrementing = false;
    public $primaryKey = 'id_kabupaten';
    public $timestamps = false;
    //public $timestamps = false;
    public function KabupatenKotaProvinsiID()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }
}
