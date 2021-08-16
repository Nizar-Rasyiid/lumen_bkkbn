<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokData extends Model
{
    protected $table     = 'kelompok_data';
    protected $fillable     = ['nama_kelompok_data','CreatedBy','LastModifiedBy'];
    //public $incrementing = false;
    public $primaryKey = 'Id_kelompok_data';
    public $timestamps = false;

    // public function KabupatenKotaProvinsiID()
    // {
    //     return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    // }
    // public function KecamatanChildId()
    // {
    //     return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan');
    // }
}
