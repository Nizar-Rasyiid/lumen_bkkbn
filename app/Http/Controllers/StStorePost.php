<?php

namespace App\Http\Requests;

class StStorePost extends BaseFormRequest
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
          'x_unit_e3_id'                      => 'required',
          'x_ma_id'                           => 'required',
          //'x_jenis'                           => 'required',
          //'x_maksud'                           => 'required',
          'x_tipe_durasi'                     => 'required',
          'x_asal_id'                         => 'required',
          'x_tgl_brkt'                        => 'required|date_format:Y-m-d',
          'x_jenis'                          => 'required',
          'x_tj_transpor'                     => 'required',
          'x_alat_angkutan_id'                => 'required',
          //'x_tujuan_id_1'                     => 'required',
          'x_durasi_1'                        => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
          'x_alat_angkutan_id_1'              => 'required',
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
