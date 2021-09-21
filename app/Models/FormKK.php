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
     'NOKK',
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
    
    public function RwID()
    {
        return $this->belongsTo('App\Models\Rw', 'id_rw', 'id_rw');
    }
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
