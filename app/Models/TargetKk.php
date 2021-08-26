<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetKk extends Model
{
    protected $table     = 'target_kk';
    protected $fillable    = [
    'Periode_Sensus',
    'id_provinsi',
    'id_kabupaten',
    'id_kecamatan',
    'id_kelurahan',
    'id_rw',
    'id_rt',
    'Target_KK',
    'CreatedBy',
    'LastModifiedBy'];
    //public $incrementing = false;
    public $primaryKey = 'id_rt';
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
