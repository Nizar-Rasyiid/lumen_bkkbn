<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $fillable = ['nama_kelurahan','KodeDepdagri','id_kecamatan','IsActive','CreatedBy','LastModifiedBy'];
    public $primaryKey = 'id_kelurahan';
    public $timestamps = false;

    // public function KabupatenKotaID()
    // {
    //     return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    // }

    // public function ProvinsiKotaID()
    // {
    //     return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    // }

    public function KecamatanId()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }
}

