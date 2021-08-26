<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessSurvey extends Model
{
    protected $table = 'user_access_survey';
    //public $incrementing = false;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_user', 
        'id_provinsi', 
        'id_kabupaten',
        'id_kecamatan',
        'id_kelurahan',
        'id_rw',
        'id_rt',
        'Periode_Sensus',
        'CreatedBy',
        'LastModifiedBy',
    ];

    public function RtID()
    {
        return $this->belongsTo('App\Models\Rt', 'id_rt', 'id_rt');
    }
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
