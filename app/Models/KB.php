<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KB extends Model
{
    protected $table = 'data_kb';
    //public $incrementing = false;
    protected $primaryKey = 'data_kb_id';
    public $timestamps = false;
    protected $fillable = [
        "KK_id",
        "NIK",
        // "nama_anggota",
        // "anggota_kk_id",
        "alat_kontrasepsi",
        "tahun_pemakaian",
        "alasan",
        "CreatedBy",
        "LastModifiedBy"
    ];
}
