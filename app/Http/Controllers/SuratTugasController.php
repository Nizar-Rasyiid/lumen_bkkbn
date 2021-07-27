<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StStorePost;
use App\Http\Requests\StStore2Post;
use Auth;
use App\Models\Spd;


use App\Models\Kota;
use App\Models\Pegawai;
use App\Models\Unit;
use App\Models\AlatAngkutan;
use App\Models\MataAnggaran;
use App\Models\Pejabat;

use Session;


use App\Models\SuratTugas;
use App\Models\SuratTugasMataAnggaran;
use App\Models\PPK;
use Illuminate\Support\Facades\Cookie;

use PDF;

class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo("dsdsdsdsd=".$_COOKIE[$_ENV['EW_PROJECT_NAME'] . '_nama']);
        return view('SuratTugas.index');
    }


    public function detail($ids)
    {
        $SuratTugas_list = SuratTugas::where("id", $ids)->with('SuratTugasMataAnggaran')
        ->with('SuratTugasTujuan1')
        ->with('SuratTugasTujuan2')
        ->with('SuratTugasTujuan3')
        ->with('SuratTugasTujuan4')
        //->with('SuratTugasUnit')
        ->with('SuratTugasAsal')
        ->with('SuratTugasAlatAngkutan')
        ->get();
        $jenis2="";
        /* */
        $arrJenis=explode("|", $SuratTugas_list[0]->jenis);
        //var_dump($SuratTugas_list[0]->jenis);/*
        foreach ($arrJenis as $jenis) {
            if ($jenis=="1") {
                $jenis2=$jenis2."Luar Kota,";
            } elseif ($jenis=="2") {
                $jenis2=$jenis2."Dalam Kota &gt; 8 Jam, ";
            } elseif ($jenis=="3") {
                $jenis2=$jenis2."Diklat, ";
            } elseif ($jenis=="4") {
                $jenis2=$jenis2."Fullboard Luar Kota, ";
            } elseif ($jenis=="5") {
                $jenis2=$jenis2."Fullboard Dalam Kota,";
            } elseif ($jenis=="6") {
                $jenis2=$jenis2."Fullday Halfday Dalam Kota,";
            } elseif ($jenis=="7") {
                $jenis2=$jenis2."Dalam Kota s.d. 8 Jam,";
            } elseif ($jenis=="8") {
                $jenis2=$jenis2."Luar Negeri";
            };
        }
//        echo $SuratTugas_list[0]->jenis;

        $SuratTugas_list[0]->jenis=$jenis2;
        //echo $SuratTugas_list[0]->jenis;
        //echo $SuratTugas_list[0]->tgl_st."=";
        //var_dump($SuratTugas_list);
        return view('SuratTugas.detail', compact(
            'SuratTugas_list'
        ));
    }
    public function cetakpdf($ids)
    {
        $SuratTugas_list = SuratTugas::where("id", $ids)->with('SuratTugasMataAnggaran')
        ->with('SuratTugasTujuan1')
        ->with('SuratTugasTujuan2')
        ->with('SuratTugasTujuan3')
        ->with('SuratTugasTujuan4')
        ->with('SuratTugasUnit')
        ->with('SuratTugasAsal')
        ->with('SuratTugasAlatAngkutan')
        ->get();
        $SuratTugas="";
        $data_json = json_decode($SuratTugas_list, true);
        //var_dump($data_json);
        $array_data_SuratTugas = array();

        foreach ($data_json as $key=>$value) {
            foreach ($value as $key=>$value2) {
                $array_data_SuratTugas[$key]=$value2;
            }
        }
        $data = array(
                    'SuratTugas_list'   => $SuratTugas_list,
                );
        //var_dump($data);
        /** */
        $pdf = PDF::loadView('SuratTugas.cetakpdf', $data);
        /** */
        return $pdf->setPaper('A4', 'potrait')
            ->download("SuratTugas" . '_' . date("Y-m-d") . '.pdf');
        /**/
    }

    public function getSuratTugas()
    {

        //$userId = Auth::user()->id;
        //$kode="1885.025.007.011.524111";
        $nip=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_nama');
        $es_3_id=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3_id');
        //$es_3_id="352";
        //echo "es_3_id=".$es_3_id."        ";
        $SuratTugas_list = SuratTugas::where('unit_e3_id', $es_3_id)//$es_3_id)
        //$SuratTugas_list = SuratTugas::where('unit_e3_id', $es_3_id)//$es_3_id)
        ->with('SuratTugasMataAnggaran')->get();

        

        return datatables()->of($SuratTugas_list)


                                   ->addColumn('NoCutome', function ($row) {
                                       $NoCutome=$row->no;
                                       /*                               $btnModal = '
                                       <a href="#dokumenModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="showDokumenModal('."'".$row->file_bukti_pemenuhan_kewajiban."', "."'".asset('storage/'.$row->perusahaan->nama."/IPB/FILE_BUKTI_PEMENUHAN_KEWAJIBAN/".$row->file_bukti_pemenuhan_kewajiban). "'" .')">'.$row->file_bukti_pemenuhan_kewajiban.'</a>';
        */

                                       return $NoCutome;
                                   })
                                    

                                   ->addColumn('MaksudDiv', function ($row) {
                                       $MaksudDiv=$row->maksud;
                                       /*                               $btnModal = '
                                       <a href="#dokumenModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="showDokumenModal('."'".$row->file_bukti_pemenuhan_kewajiban."', "."'".asset('storage/'.$row->perusahaan->nama."/IPB/FILE_BUKTI_PEMENUHAN_KEWAJIBAN/".$row->file_bukti_pemenuhan_kewajiban). "'" .')">'.$row->file_bukti_pemenuhan_kewajiban.'</a>';
        */

                                       return $MaksudDiv;
                                   })

                                   ->addColumn('UnitNama', function ($row) {
                                       $UnitNama=$row->nama_unit_3;
                                       /*                               $btnModal = '
                                       <a href="#dokumenModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="showDokumenModal('."'".$row->file_bukti_pemenuhan_kewajiban."', "."'".asset('storage/'.$row->perusahaan->nama."/IPB/FILE_BUKTI_PEMENUHAN_KEWAJIBAN/".$row->file_bukti_pemenuhan_kewajiban). "'" .')">'.$row->file_bukti_pemenuhan_kewajiban.'</a>';
        */

                                       return $UnitNama;
                                   })

                           ->addColumn('mata_anggaran', function ($row) {
                               $mataAnggaran= $row->SuratTugasMataAnggaran->kode." \n". $row->SuratTugasMataAnggaran->nama;//   '

                               return $mataAnggaran;
                           })
                           
                           ->addColumn('action', function ($row) {
                               $Spd_count = Spd::where("st_id", $row->id)->count();
                               $btn="";
                               //if ($Spd_count>0) {
                               $btn= "<a href=\"spd/InputgetSpd/"
                                            .$row->id.
                                            "\" class=\"btn btn-info btn-xs\" 
                                            data-toggle=\"tooltip\" title=\"SPPD\">
                                            SPPD ".$Spd_count."</a>";
                               //};


                               $btn .=
                               "<a href=\"st/detail/".$row->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Detail\"><i class=\"fa fa-search\"></i> Detail </a>";
                               if ($row->ppk_id!=null) {
                                   $btn .=
                                    "<a href=\"report/notadinas/".$row->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Cetak PDF\">Notadinas</a>";
                               }
                               /*'
                            <button class="btn btn-info btn-xs"><i class="fa fa-clone"></i>Detail</button>';
*/
                               return $btn;
                           })


                           ->rawColumns(['NoCutome','idSt','UnitNama', 'mata_anggaran','MaksudDiv', 'action'])
                           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $St             = session('SuratTugas');
        //$perusahaan      = session('perusahaan');
        $es_3_id=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3_id');
        $es_3=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3');
        $kode_org_3=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_kode_org_3');

        //$mata_anggota_list = SuratTugas::where('user_id', Auth::user()->id)->get();
        $MataAnggaran_list = MataAnggaran::where('unit_e3_id', $es_3_id)->get();
        $Pegawai_list = Pegawai::get();
        $AlatAngkutan_list = AlatAngkutan::get();
        $Kota_list = Kota::get();

        //$es_3_id=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3_id');



        //$tahapan_list    = Tahapan::all();
        return view('SuratTugas.create', compact(
            'MataAnggaran_list',
            'Pegawai_list',
            'AlatAngkutan_list',
            'Kota_list',
            'es_3_id',
            'es_3',
            'kode_org_3'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function editStore(StStore2Post $request)
    {
        $St = SuratTugas::where('id', $request->x_id);
        $St->update(['no_kendaraan' => $request->x_no_kendaraan]);
        $St->update(['maksud' => $request->x_maksud]);
        $St->update(['tgl_st' => $request->x_tgl_st]);
        $St->update(['ppk_id' => $request->x_ppk_id]);
        $St->update(['pst_id' => $request->x_pst_id]);

        $St->update(['anst_id' => $request->x_anst_id]);
        $St->update(['pengesah_brkt_id' => $request->x_pengesah_brkt]);
        $St->update(['status' => $request->x_status]);
        $St->update(['konsiderans' => $request->x_konsiderans]);

        $St =$St->first();
        $id_st=$St->id;
        //return redirect()->route('st.edit', [$id_st])->with('id_st', $id_st);
        return redirect()->route('spd.InputgetSpd', [$request->x_id])->with('id_st', $id_st);

        
        //$St->save;
    }


    public function store(StStorePost $request)
    {
        $idUnit=$request->x_unit_e3_id;
        //echo($idUnit." = ");
        if ($request->x_jum>1) {
            if ($request->x_jum==4) {
                $rules = [
                    'x_alat_angkutan_id_2' => 'required',
                    'x_durasi_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_2' => 'required',
                    'x_alat_angkutan_id_3' => 'required',
                    'x_durasi_3' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_3' => 'required',

                    'x_alat_angkutan_id_4' => 'required',
                    'x_durasi_4' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_4' => 'required',
                ];
            } elseif ($request->x_jum==3) {
                $rules = [
                    'x_alat_angkutan_id_2' => 'required',
                    'x_durasi_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_2' => 'required',
                    'x_alat_angkutan_id_3' => 'required',
                    'x_durasi_3' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_3' => 'required',

                ];
            } elseif ($request->x_jum==2) {
                $rules = [
                    'x_alat_angkutan_id_2' => 'required',
                    'x_durasi_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tujuan_id_2' => 'required',

                ];
                $messages = [
                                'x_alat_angkutan_id_2.required' => 'Please x alat angkutan id 2',
                                'x_durasi_2.required'=> 'Please x Durasi 2',
                                'x_tujuan_id_2.required'=> 'Please x Tujuan 2',
                ];
            }
            $this->validate($request, $rules, $messages);
        }

        // Validate "Rules" and "Messages" to running.

        $kodeUnit=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_kode_org_3');
        $nama_unit_3=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3');
        $nama_unit_2=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_2');

        //
//        $Ma->fill(['unit_e3_id' =>]);
        //$kodeUnit=
        //Unit::where("id", $idUnit)->first();
        //var_dump($kodeUnit);
        //echo($kodeUnit->kode);

        $notugas_template="/ST/".$kodeUnit."/".date('Y');
        //echo($notugas_template."");
        $notugas_list = SuratTugas::where("no", "like", "%". strtolower($notugas_template))
        ->max('no');
        $templateNotugas="";
        if ($notugas_list!=null) {
            //var_dump($notugas_list);
            $arrtemplate=explode($notugas_template, $notugas_list);
            $template=$arrtemplate[0]+1;
            //$templateNotugas=str_repeat("0", 3);
            //echo $templateNotugas;
            $templateNotugas= str_pad($template, 3, "0", STR_PAD_LEFT).$notugas_template;
        } else {
            $templateNotugas="001".$notugas_template;
        }
        //$tahapan = Tahapan::where('nama', $request->tahapan_kegiatan)->first();
        // dd($tahapan->id);
        $St = new SuratTugas;
        //var_dump($request->x_jenis);
        //echo $request->x_unit_e3_id;
        $var_jenis=implode("|", $request->x_jenis);
        $St->fill(['unit_e3_id' => $request->x_unit_e3_id]);
        $St->fill(['tgl_st' => date('Y-m-d')]);
        $St->fill(['tgl_spd2' => date('Y-m-d')]);
        //$St->fill(['maksud' => $request->x_maksud]);
        
        $St->fill(['no' => $templateNotugas/* $request->x_no*/]);
        $St->fill(['ma_id' => $request->x_ma_id]);
        $St->fill(['jenis' => $var_jenis]);
        $St->fill(['tgl_brkt' => $request->x_tgl_brkt]);
        $St->fill(['nama_unit_3' => $nama_unit_3]);
        $St->fill(['nama_unit_2' => $nama_unit_2]);
        $St->fill(['nama_unit_1' => $nama_unit_1]);

//        $tgl_plg=date_add(date('Y-m-d', strtotime($request->x_tgl_brkt)), 1);
//        echo $tgl_plg;
        
        //echo $request->x_tgl_brkt;
        $date=date_create($request->x_tgl_brkt);


        //$dateTot=$date;
        //echo date_format($date, "Y-m-d");
        //      echo $request->x_alat_angkutan_id_1;
        $St->fill(['tgl_plg' => $date]);
        $St->fill(['asal_id' => $request->x_asal_id]);
        $St->fill(['tj_transpor' => $request->x_tj_transpor]);
        $St->fill(['alat_angkutan_id' => $request->x_alat_angkutan_id]);
        
        $St->fill(['tujuan_id_1' => $request->x_tujuan_id_1]);
        $St->fill(['durasi_1' => $request->x_durasi_1]);
        $St->fill(['alat_angkutan_id_1' => $request->x_alat_angkutan_id_1]);

        $St->fill(['tipe_durasi' => $request->x_tipe_durasi]);

        $St->fill(['tujuan_id_2' => $request->x_tujuan_id_2]);
        $St->fill(['durasi_2' => $request->x_durasi_2]);
        $St->fill(['alat_angkutan_id_2' => $request->x_alat_angkutan_id_2]);

        $St->fill(['tujuan_id_3' => $request->x_tujuan_id_3]);
        $St->fill(['durasi_3' => $request->x_durasi_3]);
        $St->fill(['alat_angkutan_id_3' => $request->x_alat_angkutan_id_3]);

        $St->fill(['tujuan_id_4' => $request->x_tujuan_id_4]);
        $St->fill(['durasi_4' => $request->x_durasi_4]);
        $St->fill(['alat_angkutan_id_4' => $request->x_alat_angkutan_id_4]);
        $St->fill(['kode_eselon_induk' => $request->$kodeUnit]);

        

        $St->save();
        //echo $templateNotugas;
        $St_id=SuratTugas::where("no", $templateNotugas)
        ->with('SuratTugasMataAnggaran')
        ->with('SuratTugasAsal')
        ->with('SuratTugasTujuan1')
        ->with('SuratTugasUnit')
        ->with('SuratTugasAlatAngkutan1')
        ->first();

        $id_st=$St_id->id;
//        echo $St->id;
//        Session::put('IdSt', $St_id->id);

        //$request->session()->put('St', $St_id);

        //return redirect()->route('st.edit', [$id_st])->with('id_st', $id_st);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$st=Session::get('St');

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_st)
    {
        //$SuratTugas_list=Session::get('St');
        $SuratTugas_list=SuratTugas::where('id', $id_st)
         ->with('SuratTugasMataAnggaran')
        ->with('SuratTugasAsal')
        ->with('SuratTugasTujuan1')
        ->with('SuratTugasUnit')
        ->with('SuratTugasAlatAngkutan1')
        ->get();
        
        $jenis2="";
        $SuratTugas_list[0]->tgl_spd2=$SuratTugas_list[0]->tgl_plg;
        $SuratTugas_list[0]->maksud=$SuratTugas_list[0]->SuratTugasMataAnggaran->nama;
        //echo "=".$SuratTugas_list[0]->jenis;
        $arrJenis=explode("|", $SuratTugas_list[0]->jenis);
        foreach ($arrJenis as $jenis) {
            if ($jenis=="1") {
                $jenis2=$jenis2."Luar Kota,";
            } elseif ($jenis=="2") {
                $jenis2=$jenis2."Dalam Kota &gt; 8 Jam, ";
            } elseif ($jenis=="3") {
                $jenis2=$jenis2."Diklat, ";
            } elseif ($jenis=="4") {
                $jenis2=$jenis2."Fullboard Luar Kota, ";
            } elseif ($jenis=="5") {
                $jenis2=$jenis2."Fullboard Dalam Kota,";
            } elseif ($jenis=="6") {
                $jenis2=$jenis2."Fullday Halfday Dalam Kota,";
            } elseif ($jenis=="7") {
                $jenis2=$jenis2."Dalam Kota s.d. 8 Jam,";
            } elseif ($jenis=="8") {
                $jenis2=$jenis2."Luar Negeri";
            };
        }
//        echo $SuratTugas_list[0]->jenis;

        $SuratTugas_list[0]->jenis=$jenis2;
        /**/
        //echo " = ".$st->unit_e3_id;
        /* */
        //$unit_e3_id=$SuratTugas_list[0]->unit_e3_id;
        $es_2_id=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_2_id');
        //echo $es_2_id;
        /*$ppk_list=PPK::whereHas('PpkUnit', function ($query) use ($es_2_id) {
            $query->where('unit_id', '=', $es_2_id);
        })*/
        $ppk_list=PPK::where('unit_id', '=', $es_2_id)
        ->get();


        /*        $UnitGrandParentID_table=Unit::where('id', $unit_e3_id)
                ->with("UnitGrandParentID")
                ->first();
                $UnitGrandParentID=$UnitGrandParentID_table->induk_id;


                $parentUnit_tabel=Unit::where('id', $unit_e3_id)
                ->first();
                $parentUnit=$parentUnit_tabel->induk_id;

                $HeadOfUnitID=Pejabat::where('unit_id', $unit_e3_id)->first();

                //echo $unit_e3_id." = ".$parentUnit." = ". $HeadOfUnitID->kepala_id;
        /*        $pst_list=Pegawai::whereHas('PegawaiUnit', function ($query) use ($parentUnit,$UnitGrandParentID) {
                    $query->where('unit_e2_id', $parentUnit)
                    ->where('eselon_id', '2')
                    ->orWhere('induk_id', $UnitGrandParentID)
                    ->where('eselon_id', '1');
                })
                //->where('id', $HeadOfUnitID->kepala_id)
                ->get();
        */
        /*        $anst_list=Pegawai::whereHas('PegawaiUnit', function ($query) use ($parentUnit) {
                    $query->where('unit_e2_id', $parentUnit)
                 ->where('eselon_id', '2')
                 ->orWhere('eselon_id', '3')
                 ->where('unit_e2_id', $parentUnit)
                 ->orWhere('eselon_id', '4')
                 ->where('unit_e2_id', $parentUnit);
                })
                ->get();
        //        var_dump($anst_list);
        */
        /*
                $pengesah_brkt_list=Pegawai::whereHas('PegawaiUnit', function ($query) use ($parentUnit,$UnitGrandParentID) {
                    $query->where('unit_e2_id', $parentUnit)
                    ->where('eselon_id', '<=', '3');
                })->get();
        */


        //var_dump($pengesah_brkt_list);
        //$pengesah_brkt_list=$pst_list;
        //echo $unit_e3_id;
        /* */
        //var_dump($ppk_list);

        return view('SuratTugas.edit', compact(
            'SuratTugas_list',
            'ppk_list'
//          'pst_list',
//            'anst_list',
//            'pengesah_brkt_list'
        ));
        /**/
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
