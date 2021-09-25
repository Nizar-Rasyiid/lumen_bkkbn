<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormKK extends Model
{
    protected $table = 'table_kk_periode_sensus';
    //public $incrementing = false;
    protected $primaryKey = 'KK_id';
    public $timestamps = false;
    protected $fillable = [
     'periode_sensus',
     'NoKK',
     'NIK_KK',
     'nama_kk',
     'alamat_kk',
     'id_provinsi',
     'id_kab',
     'id_kec',
     'id_kel',
     'id_rw',
     'id_rt',
     'create_by',
     'update_by'    
    ];
}
