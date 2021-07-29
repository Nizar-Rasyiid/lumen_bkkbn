<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class WkpLokasi extends Model
{
    use Uuid;

    protected $table = 'ebtke_panasbumi_wkp_lokasi';
    public $incrementing = false;

    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'kota_id');
    }
}
