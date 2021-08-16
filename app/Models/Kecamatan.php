<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $fillable = ['nama_kecamatan','KodeDepdagri','id_kabupaten','IsActive','CreatedBy','LastModifiedBy'];   
    public $primaryKey = 'id_kecamatan';
    public $timestamps = false;

    public function KabupatenKotaKecamatanId()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten');
    }

    // public function ProvinsiKotaId()
    // {
    //     return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    // }
}

