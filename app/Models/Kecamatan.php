<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table     = 'Kecamatan';
    //public $incrementing = false;
    public $primaryKey = 'id_kabupaten';
    //public $timestamps = false;
    public function KecamatanKabupatenID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    }
}
