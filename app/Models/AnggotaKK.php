<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKK extends Model
{
    protected $table = 'anggota_kk_periode_sensus';
    //public $incrementing = false;
    protected $primaryKey = 'anggota_kk_id';
    public $timestamps = false;
    protected $fillable = [
    'KK_id',
     'periode_sensus',
     'nama_anggota',
     'NIK',
     'jenis_kelamin',
     'tempat_lahir',
     'tanggal_lahir',
     'agama',
     'pendidikan',
     'jenis_pekerjaan',
     'status_nikah',
     'tanggal_pernikahan',
     'status_dalam_keluarga',
     'kewarganegaraan',
     'no_paspor',
     'no_katas',
     'nama_ayah',
     'nama_ibu',
     'create_date',
     'update_date',
     'create_by',
     'update_by'    
    ];
    
}
