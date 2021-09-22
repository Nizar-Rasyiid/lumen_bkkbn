<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatKB extends Model
{
    protected $table = 'data_kb';
    //public $incrementing = false;
    protected $primaryKey = 'data_kb';
    public $timestamps = false;
    protected $fillable = [
    'KK_id',
     'NIK',
     'alat_kontrasepsi',
     'tahun_pemakaian',
     'alasan',
    ];
}
