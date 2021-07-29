<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class Spd extends Model
{
    //use Uuid;

    protected $table = 'spd';
    public $incrementing = false;
    public $primaryKey = 'id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //$table->increments('id');
    /* */
    protected $fillable = [
          'no',
          'pegawai_id',
          'jenis_pelaksana',
          'non_pegawai_id',
          'tiket',
          'taksi',
          'durasi_1',
          'harian_1',
          'hotel_1',
          'durasi_2',
          'harian_2',
          'hotel_2',
          'durasi_3',
          'harian_3',
          'hotel_3',
          'durasi_4',
          'harian_4',
          'hotel_4',
          'representasi',
          'st_id',
          'kode_tiket',
          'tgl_plg',
          'pspd_id',
          'kode_tiket_1',
          'tiket_1',
          'tax1',
          'kode_tiket_2',
          'tiket_2',
          'tax2',
          'kode_tiket_3',
          'tiket_3',
          'tax3',
          'kode_tiket_4',
          'tiket_4',
          'tax4',
          'lain_desc',
          'lain_amt',
          'rapat',
          'cacah_harian',
          'dlmkota',
          'cacah_hotel_1',
          'cacah_hotel_2',
          'cacah_hotel_3',
          'cacah_hotel_4',
          'nonhotel_1',
          'nonhotel_2',
          'nonhotel_3',
          'nonhotel_4',


          //'id',
          //'no_kendaraan',

      ];

    public function SpdSuratTugas()
    {
        return $this->belongsTo('App\Models\SuratTugas', 'st_id');
    }

    public function SpdPegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'non_pegawai_id');
    }

    public function SpdPspd()
    {
        return $this->belongsTo('App\Models\Pegawai', 'pspd_id');
    }
}
