<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $table    = 'rw';
    //public $incrementing = false;
    protected $primaryKey = 'id_rw';
    public $timestamps = false;
    protected $fillable = ['nama_rw', 'KodeDepdagri','IsActive','id_kelurahan','CreatedBy','LastModifiedBy'];
    
    public function KelurahanId()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'id_kelurahan', 'id_kelurahan');
    }
    public function KabupatenKotaID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    }

    public function ProvinsiKotaID()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }

    public function KecamatanId()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }
    
    public function VuserId()
    {
        return $this->belongsTo('App\Models\V_user');
    }
}