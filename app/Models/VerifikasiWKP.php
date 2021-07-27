<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class VerifikasiWKP extends Model
{
    use Uuid;

    protected $table = 'verifikasi_wkp';
    public $incrementing = false;

    protected $fillable  = [
    'id_ipb',
    'status_verifikasi',
    'keterangan',
    'verifikasi_wkp',
  ];
}
