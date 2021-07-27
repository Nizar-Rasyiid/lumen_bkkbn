<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class VerifikasiIPB extends Model
{
    use Uuid;

    protected $table = 'verifikasi_ipb';
    public $incrementing = false;

    protected $fillable  = [
    'id_ipb',
    'status_verifikasi',
    'keterangan',
    'verifikasi_ipb',
  ];

    public function perusahaan()
    {
        return $this->belongsTo('App\Models\Perusahaan');
    }
}
