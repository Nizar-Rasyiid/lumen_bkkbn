<?php

namespace App\Http\Requests;

class SpdStorePost extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    
    public function authorize()
    {
        return true;
        //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'x_pegawai_id'                      => 'required',
          //'x_ma_id'                           => 'required',
          //'x_jenis'                           => 'required',
          'x_tiket'                           => 'required',
          'x_taksi'                     => 'required',
          'x_tax'                         => 'required',
           'x_harian_1'                        => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_hotel_1'                     => 'required',
          'x_taksi_1'                => 'required',
          //'x_tujuan_id_1'                     => 'required',
          'x_durasi_1'                        => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_representasi'              => 'required',
          'x_tgl_plg'              => 'required|date_format:Y-m-d',
          'x_lain_desc'             => 'required',
          'x_lain_amt'             => 'required',
          'x_rapat'             => 'required',
          'x_cacah_harian'      => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_dlmkota'      => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_kurs'      => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_cacah_hotel_1'      => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_nonhotel_1'      => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          //'x_tujuan_id_2'                     => 'required',
          //'x_tujuan_id_2'                     => 'required',
          //'x_durasi_2'                        => 'required',
          //'x_alat_angkutan_id_2'              => 'required',
          //'x_tujuan_id_3'                     =>  'required',
          //'x_durasi_3'                        =>  'required',
          //'x_alat_angkutan_id_3'              =>  'required',
          //'x_tujuan_id_4'                     =>  'required',
          //'x_durasi_4'                        =>  'required',
          //'x_alat_angkutan_id_4'              =>  'required',
        ];
    }
}
