<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table     = 'setting';
    protected $fillable     = ['nama','value_setting','Id_kelompok_data','CreatedBy','LastModifiedBy'];
    //public $incrementing = false;
    public $primaryKey = 'id_setting';
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
