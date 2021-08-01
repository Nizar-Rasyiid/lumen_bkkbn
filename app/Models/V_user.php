<?php

namespace App\Models;

//use App\Traits\Uuid;


use Illuminate\Database\Eloquent\Model;

class V_user extends Model
{
    protected $table = 'v_user';
    //public $incrementing = false;
    protected $fillable = [
      'id',
      'PeriodeSensus',
      'UserName',
      'Password',
      'NamaLengkap',
      'NIK',
      'Jabatan',
      'Foto',
      'KabupatenKotaID',
      'NoTelepon',
      'Email',
      'NIP',
      'IsTemporary',
      'RoleID',
      'TingkatWilayahID',
      'IsActive',
      'CreatedDate',
      'CreatedBy',
      'LastModified',
      'LastModifiedBy',
      'Smartphone',
      'EmailSent',


    ];
    public function UserRoleID()
    {
        return $this->belongsTo('App\Models\V_role', 'id', 'RoleID');
    }
    public function UserTingkatWilayahID()
    {
        return $this->belongsTo('App\Models\TingkatWilayah', 'id', 'TingkatWilayahID');
    }
    public function UserKabupatenKotaID()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten', 'KabupatenKotaID');
    }

    //
}
