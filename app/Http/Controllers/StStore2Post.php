<?php

namespace App\Http\Requests;

class StStore2Post extends BaseFormRequest
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
          'x_maksud'                      => 'required',
          'x_tgl_st'                           => 'required|date_format:Y-m-d',
          'x_ppk_id'                     => 'required',
          'x_pst_id'                         => 'required',
          'x_anst_id'                        => 'required',
          'x_pengesah_brkt'                    => 'required',
          'x_konsiderans'                    => 'required',
        ];
    }
}
