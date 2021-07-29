<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $fillable = ['nama_kecamatan','KodeDepdagri','id_kabupaten','IsActive'];
    public $primaryKey = 'id_kecamatan';
    public $timestamps = false;

    public function KabupatenKotaID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    }
}

