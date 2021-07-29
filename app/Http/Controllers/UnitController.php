<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PegStorePost;

use Auth;

use App\Models\Unit;
//use App\Models\Eselon;
//use App\Models\Pangkat;

//use App\Models\Pegawai;
use Session;


use PDF;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        //return view('Pegawai.index');
    }
    
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
