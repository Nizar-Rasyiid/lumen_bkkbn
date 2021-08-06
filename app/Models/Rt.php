<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $table    = 'rt';
    //public $incrementing = false;
    protected $primaryKey = 'id_rt';
    public $timestamps = false;
    protected $fillable = ['KodeRT', 'nama_rt','id_rw','IsActive'];
    
    public function RwID()
    {
        return $this->belongsTo('App\Models\Rw', 'id_rw', 'id_rw');
    }
    public function KelurahanId()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'id_kelurahan', 'id_kelurahan');
    }
    public function KabupatenKotaID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    }

    public function ProvinsiKotaID()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }

    public function KecamatanId()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }

}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $table    = 'rt';
    //public $incrementing = false;
    protected $primaryKey = 'id_rt';
    public $timestamps = false;
    protected $fillable = ['KodeRT', 'nama_rt','id_rw','IsActive'];
    
    public function RwID()
    {
        return $this->belongsTo('App\Models\Rw', 'id_rw', 'id_rw');
    }
    public function KelurahanId()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'id_kelurahan', 'id_kelurahan');
    }
    public function KabupatenKotaID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'id_kabupaten');
    }

    public function ProvinsiKotaID()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }

    public function KecamatanId()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }

}
>>>>>>> b81825e0d43d5af4f9d4dbd9efddf215e69fe48b
