<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class Wkp extends Model
{
    use Uuid;

    protected $table = 'ebtke_panasbumi_wkp';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'nama_wkp',
      'nomor_sk',
      'tanggal_sk',
      'file_sk',
      'file_ba_usulan_dbh',
      'ipb_id',
  ];

    public function wkp_lokasi()
    {
        return $this->hasMany('App\Models\WkpLokasi', 'wkp_id');
    }
}
