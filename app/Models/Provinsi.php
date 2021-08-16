<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table ='provinsi';
    protected $fillable =['KodeDepdagri','nama_provinsi','IsActive','CreatedBy','LastModifiedBy'];
    //public $incrementing = false;
    public $primaryKey = 'id_provinsi';
    public $timestamps = false;

    public function Kabupaten()
    {
        $this->belongsTo('App\Models\Kabupaten');
    }
    public function Kecamatan()
    {
        $this->belongsTo('App\Models\Kecamatan');
    }
    public function Kelurahan()
    {
        $this->belongsTo('App\Models\Kelurahan');
    }
    public function Rw()
    {
        $this->belongsTo('App\Models\Rw');
    }
    public function Rt()
    {
        $this->belongsTo('App\Models\Rt');
    }
}
