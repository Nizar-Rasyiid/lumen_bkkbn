<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $fillable = ['nama_kelurahan','KodeDepdagri','id_kecamatan','nama_kecamatan','IsActive'];
    public $primaryKey = 'id_kelurahan';
    public $timestamps = false;

    public function KecamatanId()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }
    // public function KecamatanName()
    // {
    //     return $this->belongsTo('App\Models\Kecamatan', 'nama_kecamatan');
    // }
}