<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SpdStorePost;
use Auth;
use App\Models\Spd;
use App\Models\Unit;

use App\Models\Pegawai;
use Session;


use App\Models\SuratTugas;
use Illuminate\Support\Facades\Cookie;

use PDF;

class SpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('SuratTugas.index');
    }



    public function InputgetSpd($IdSt)
    {
        Session::put('IdSt', $IdSt);

        $st_id=Session::get('IdSt');

        /*$st=SuratTugas::where("id", $st_id)->first();
        $unit_e3_id=$st->unit_e3_id;
        $Unit_list = Unit::where("id", $unit_e3_id)->first();*/
//        $unit_e2_id=$Unit_list->induk_id;
        $unit_e2_id=Cookie::get($_ENV['EW_PROJECT_NAME'] . '_es_3_id');

//        $Pegawai_list = Pegawai::where("unit_e2_id", $unit_e2_id)->get();
        $Pegawai_list = Pegawai::get();

//        $Pegawai_list=$array["data"];

        
        return view('Spd.Inputgetspd', compact(
            'unit_e2_id'//,
            //'Pegawai_list'
        ));
    }


    public function InputgetSpdSession()
    {
        $st_id=Session::get('IdSt');

        $st=SuratTugas::where("id", $st_id)->first();
        $unit_e3_id=$st->unit_e3_id;
        $Unit_list = Unit::where("id", $unit_e3_id)->first();
        $unit_e2_id=$Unit_list->induk_id;

        $Pegawai_list = Pegawai::where("unit_e2_id", $unit_e2_id)->get();

        //var_dump($Pegawai_list);
        
        return view('Spd.Inputgetspd', compact(
            'Pegawai_list'
        ));
    }

    public function getSpd()
    {
        $st_id=Session::get('IdSt');
//        $st=SuratTugas::where("id", $st_id)->first();

        
        //var_dump($Pegawai_list);
        $Spd_list = Spd::where("st_id", $st_id)->with('SpdSuratTugas')
                ->with('SpdPegawai')
                ->get();
        $jenis2="";
        for ($x = 0; $x <= count($Spd_list)-1; $x++) {
            if ($Spd_list[$x]->jenis_pelaksana==0) {
                $pegawai=servicePegawaiByNIP($Spd_list[$x]->pegawai_id);
                //var_dump($pegawai);
//                echo "  <br/>   ";
//                echo $pegawai["nip"]." = ";
                /* */
                $Spd_list[$x]->niptamp=$pegawai["nip"];
                $Spd_list[$x]->namatamp=$pegawai["nama_full"];
                $Spd_list[$x]->unitnama=$pegawai["unit"];
                $Spd_list[$x]->jabatan= $pegawai["jabatan"];
                $eselon_peg="";
                if ($pegawai["unit"]==$pegawai["es_1"]) {
                    $eselon_peg="Eselon 1";
                } elseif ($pegawai["unit"]==$pegawai["es_2"]) {
                    $eselon_peg="Eselon 2";
                } elseif ($pegawai["unit"]==$pegawai["es_3"]) {
                    $eselon_peg="Eselon 3";
                } else {
                    $eselon_peg="Eselon 4";
                }

                $Spd_list[$x]->eselon= $eselon_peg;/**/
            } else {
                $Spd_list[$x]->niptamp=$Spd_list[$x]->SpdPegawai->nip;
                $Spd_list[$x]->namatamp=$Spd_list[$x]->SpdPegawai->nama;
                $Spd_list[$x]->unitnama=$Spd_list[$x]->SpdPegawai->PegawaiUnit->nama;
                $Spd_list[$x]->jabatan= $Spd_list[$x]->SpdPegawai->jabatan ;//   '
                $Spd_list[$x]->eselon= $Spd_list[$x]->SpdPegawai->PegawaiEselon->eselon;//   '
            }

            $Spd_list[$x]->action =
             "<a href=\"/spd/detail/".$Spd_list[$x]->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Detail\"><i class=\"fa fa-search\"></i> Detail </a>
                               <a href=\"/spd/cetakpdf/".$Spd_list[$x]->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Cetak PDF\">CetakPDF</a>";
        }



        //var_dump($Spd_list[0]->SpdPegawai->PegawaiEselon);
        //echo($Spd_list[0]->jenis_pelaksana);
        
        return datatables()->of($Spd_list)
        
/*
                            ->addColumn('niptamp', function ($row) {
                                $niptamp="<textarea  cols='15' rows='5%'style='min-height:10%;pointer-events: none;border: 0 none;background-color: transparent; outline: none;'>".$row->SpdPegawai->nip."</textarea>";

                                return $niptamp;
                            })


                            ->addColumn('namatamp', function ($row) {
                                $namatamp="<textarea  cols='25' rows='5%'style='min-height:10%;pointer-events: none;border: 0 none;background-color: transparent; outline: none;'>".$row->SpdPegawai->nama."</textarea>";
                                /*                               $btnModal = '
                                <a href="#dokumenModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="showDokumenModal('."'".$row->file_bukti_pemenuhan_kewajiban."', "."'".asset('storage/'.$row->perusahaan->nama."/IPB/FILE_BUKTI_PEMENUHAN_KEWAJIBAN/".$row->file_bukti_pemenuhan_kewajiban). "'" .')">'.$row->file_bukti_pemenuhan_kewajiban.'</a>';
                */
/*
                                return $namatamp;
                            })

                    ->addColumn('unitnama', function ($row) {
                        $unitnama="<textarea  cols='10' rows='4%'style='min-height:10%;pointer-events: none;border: 0 none;background-color: transparent; outline: none;'>".$row->PegawaiUnit->nama."</textarea>";

                        return $unitnama;
                    })

                    ->addColumn('jabatan', function ($row) {
                        $jabatan= "<textarea  cols='10' rows='5%'style='min-height:10%;pointer-events: none;border: 0 none;background-color: transparent; outline: none;'>".
                        $row->SpdPegawai->jabatan."</textarea>";//   '

                        return $jabatan;
                    })
                    ->addColumn('eselon', function ($row) {
                        $eselon= "<textarea  cols='5' rows='5%'style='min-height:10%;pointer-events: none;border: 0 none;background-color: transparent; outline: none;'>".
                        $row->SpdPegawai->PegawaiEselon->eselon."</textarea>";//   '

                        return $eselon;
                    })
*/
/*                    ->addColumn('action', function ($row) {
                        $btn =
                               "<a href=\"/spd/detail/".$row->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Detail\"><i class=\"fa fa-search\"></i> Detail </a>
                               <a href=\"/spd/cetakpdf/".$row->id."\" class=\"btn btn-info btn-xs\" data-toggle=\"tooltip\" title=\"Cetak PDF\">CetakPDF</a>";
                        /*'
                            <button class="btn btn-info btn-xs"><i class="fa fa-clone"></i>Detail</button>';
*/
/*
                        return $btn;
                    })
*/

//                           ->rawColumns(['niptamp','namatamp','unitnama','jabatan','eselon', 'action'])
                           ->make(true);
    }

    public function detail($ids)
    {
        $Spd_list = Spd::where("id", $ids)->with('SpdSuratTugas')
        ->with('SpdPegawai')
        ->with('SpdPspd')
        ->get();
        $jenis2="";

        $jenis_pelaksana="";
        for ($x=0; $x<=count($Spd_list)-1;$x++) {
            $jenis_pelaksana=$Spd_list[$x]->jenis_pelaksana;
            if ($jenis_pelaksana==0) {
                $pegawai=servicePegawaiByNIP($Spd_list[$x]->pegawai_id);
                //var_dump($pegawai);
//                echo "  <br/>   ";
//                echo $pegawai["nip"]." = ";
                /* */
                
                $Spd_list[$x]->Pegnip=$pegawai["nip"];
                $Spd_list[$x]->Pegnama=$pegawai["nama_full"];
                $Spd_list[$x]->Pegunit=$pegawai["unit"];
                $Spd_list[$x]->Pegjabatan= $pegawai["jabatan"];
            /*$eselon_peg="";

            if ($pegawai["unit"]==$pegawai["es_1"]) {
                $eselon_peg="Eselon 1";
            } elseif ($pegawai["unit"]==$pegawai["es_2"]) {
                $eselon_peg="Eselon 2";
            } elseif ($pegawai["unit"]==$pegawai["es_3"]) {
                $eselon_peg="Eselon 3";
            } else {
                $eselon_peg="Eselon 4";
            }*/
            } else {
                $Spd_list[$x]->Pegnip=$Spd_list[$x]->SpdPegawai->nip;
                $Spd_list[$x]->Pegnama=$Spd_list[$x]->SpdPegawai->nama;
                $Spd_list[$x]->Pegunit=$Spd_list[$x]->SpdPegawai->PegawaiUnit->nama;
                $Spd_list[$x]->Pegjabatan= $Spd_list[$x]->SpdPegawai->jabatan;
            }
        }

        



        return view('Spd.detail', compact(
            'Spd_list'
        ));
    }
    public function cetakpdf($ids)
    {
        $Spd_list = Spd::where("id", $ids)->with('SpdSuratTugas')
        ->with('SpdPegawai')
        ->get();

//        $Spd_list="";

        $jenis_pelaksana="";
        for ($x=0; $x<=count($Spd_list)-1;$x++) {
            $jenis_pelaksana=$Spd_list[$x]->jenis_pelaksana;
            if ($jenis_pelaksana==0) {
                $pegawai=servicePegawaiByNIP($Spd_list[$x]->pegawai_id);
                //var_dump($pegawai);
//                echo "  <br/>   ";
//                echo $pegawai["nip"]." = ";
                /* */
                
                $Spd_list[$x]->Pegnip=$pegawai["nip"];
                $Spd_list[$x]->Pegnama=$pegawai["nama_full"];
                $Spd_list[$x]->Pegunit=$pegawai["unit"];
                $Spd_list[$x]->Pegjabatan= $pegawai["jabatan"];
            } else {
                $Spd_list[$x]->Pegnip=$Spd_list[$x]->SpdPegawai->nip;
                $Spd_list[$x]->Pegnama=$Spd_list[$x]->SpdPegawai->nama;
                $Spd_list[$x]->Pegunit=$Spd_list[$x]->SpdPegawai->PegawaiUnit->nama;
                $Spd_list[$x]->Pegjabatan= $Spd_list[$x]->SpdPegawai->jabatan;
            }
        }

        $data_json = json_decode($Spd_list, true);
        //var_dump($data_json);
        $array_data_SuratTugas = array();

        $data = array(
                    'Spd_list'   => $Spd_list,
                );
        $pdf = PDF::loadView('Spd.cetakpdf', $data);
        /** */
        return $pdf->setPaper('A4', 'potrait')
            ->download("Spd" . '_' . date("Y-m-d") . '.pdf');
        /**/
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
        
        //$mata_anggota_list = SuratTugas::where('user_id', Auth::user()->id)->get();
        $MataAnggaran_list = MataAnggaran::get();
        $Pegawai_list = Pegawai::get();
        $AlatAngkutan_list = AlatAngkutan::get();
        $Kota_list = Kota::get();
        $Unit_list = Unit::get();




        //$tahapan_list    = Tahapan::all();
        return view('SuratTugas.create', compact(
            'MataAnggaran_list',
            'Pegawai_list',
            'AlatAngkutan_list',
            'Kota_list',
            'Unit_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpdStorePost $request)
    {
        $idUnit=$request->x_unit_e3_id;
        //echo($idUnit." = ");
        if ($request->x_jum>1) {
            if ($request->x_jum==4) {
                $rules = [
                    'x_tiket_2' => 'required',
                    'x_tax_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_taksi_3' => 'required',
                    'x_tax_3' => 'required',
                    'x_taksi_4' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_tax_id_4' => 'required',

                    'x_cacah_hotel_2' => 'required',
                    'x_cacah_hotel_3' => 'required',
                    'x_cacah_hotel_4' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_Non Hotel_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_Non Hotel_3' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_Non Hotel_4' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                ];
            } elseif ($request->x_jum==3) {
                $rules = [
                    'x_tiket_2' => 'required',
                    'x_tax_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_taksi_3' => 'required',
                    'x_tax_3' => 'required',
                    'x_cacah_hotel_2' => 'required',
                    'x_cacah_hotel_3' => 'required',
                    'x_Non Hotel_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_Non Hotel_3' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',


                ];
            } elseif ($request->x_jum==2) {
                $rules = [
                    'x_tiket_2' => 'required',
                    'x_tax_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',
                    'x_cacah_hotel_2' => 'required',
                    'x_Non Hotel_2' => 'required|regex:/^[0-9]{1,3}(.[0-9]{3})*(\,[0-9]+)*$/',


                ];
            }
            $this->validate($request, $rules, $messages);
        }



        //$kodeUnit=Unit::where("id", $idUnit)->first();
        //var_dump($kodeUnit);
        //echo($kodeUnit->kode);
        $st_id=Session::get('IdSt');

        $St=SuratTugas::where("id", $st_id)->with('SuratTugasMataAnggaran')->first();
        //var_dump($St->SuratTugasMataAnggaran->kode) ;
        $nosp_template="/SPD/PPK/".$St->SuratTugasMataAnggaran->kode."/".date('Y');

        //$notugas_template="/ST/".$kodeUnit->kode."/".date('Y');
        //echo($notugas_template."");
        $noSpd_list = Spd::where("no", "like", "%". strtolower($nosp_template))
        ->max('no');
        $templateNoSpd="";
        if ($noSpd_list!=null) {
            //var_dump($notugas_list);
            $arrtemplate=explode($nosp_template, $noSpd_list);
            $template=$arrtemplate[0]+1;
            $templateNoSpd= str_pad($template, 3, "0", STR_PAD_LEFT).$nosp_template;
        } else {
            $templateNoSpd="001".$nosp_template;
        }
        //$tahapan = Tahapan::where('nama', $request->tahapan_kegiatan)->first();
        // dd($tahapan->id);
        $Spd = new Spd;
        $Spd->fill(['jenis_pelaksana' => $request->x_jenis_pelaksana]);

        if ($request->x_jenis_pelaksana==0) {
            $Spd->fill(['pegawai_id' => $request->x_pegawai_id]);
        } else {
            $Spd->fill(['non_pegawai_id' => $request->x_pegawai_id]);
        }
        
        $Spd->fill(['unit_e3_id' => $request->x_unit_e3_id]);
        //$Spd->fill(['pegawai_id' =>$request->x_pegawai_id]);// date('Y-m-d')]);
        $Spd->fill(['tiket' => $request->x_tiket]);
        $Spd->fill(['taksi' => $request->x_taksi]);
        
        $Spd->fill(['no' => $templateNoSpd/* $request->x_no*/]);
        $Spd->fill(['tax' => $request->tax]);
        $Spd->fill(['durasi_1' => $request->x_durasi_1]);
        $Spd->fill(['harian_1' => $request->x_harian_1]);
        $Spd->fill(['hotel_1' => $request->x_hotel_1]);
        $Spd->fill(['taksi_1' => $request->x_taksi_1]);

        $Spd->fill(['durasi_2' => $request->x_durasi_2]);
        $Spd->fill(['harian_2' => $request->x_harian_3]);
        $Spd->fill(['hotel_2' => $request->x_hotel_1]);
        $Spd->fill(['taksi_2' => $request->x_taksi_1]);

        $Spd->fill(['durasi_3' => $request->x_durasi_3]);
        $Spd->fill(['harian_3' => $request->x_harian_3]);
        $Spd->fill(['hotel_3' => $request->x_hotel_3]);
        $Spd->fill(['taksi_3' => $request->x_taksi_3]);

        $Spd->fill(['durasi_4' => $request->x_durasi_4]);
        $Spd->fill(['harian_4' => $request->x_harian_4]);
        $Spd->fill(['hotel_4' => $request->x_hotel_4]);
        $Spd->fill(['taksi_4' => $request->x_taksi_4]);

        $Spd->fill(['representasi' => $request->x_representasi]);
        $Spd->fill(['st_id' => $st_id]);
        $Spd->fill(['kode_tiket' => $request->x_kode_tiket]);
        $Spd->fill(['tgl_plg' => $request->x_tgl_plg]);
        $Spd->fill(['pspd_id' => $request->x_pspd_id]);
        $Spd->fill(['kode_tiket_1' => $request->x_kode_tiket_1]);
        $Spd->fill(['tiket_1' => $request->x_tiket_1]);
        $Spd->fill(['tax_1' => $request->x_tax_1]);

        $Spd->fill(['kode_tiket_2' => $request->x_kode_tiket_2]);
        $Spd->fill(['tiket_2' => $request->tiket_2]);
        $Spd->fill(['tax_2' => $request->x_tax_2]);

        $Spd->fill(['kode_tiket_3' => $request->x_kode_tiket_3]);
        $Spd->fill(['tiket_3' => $request->tiket_3]);
        $Spd->fill(['tax_3' => $request->x_tax_3]);

        $Spd->fill(['kode_tiket_4' => $request->x_kode_tiket_4]);
        $Spd->fill(['tiket_4' => $request->tiket_4]);
        $Spd->fill(['tax_4' => $request->x_tax_4]);

        $Spd->fill(['lain_desc' => $request->x_lain_desc]);
        $Spd->fill(['lain_amt' => $request->x_lain_amt]);
        $Spd->fill(['rapat' => $request->x_rapat]);
        $Spd->fill(['cacah_harian' => $request->x_cacah_harian]);
        $Spd->fill(['dlmkota' => $request->x_dlmkota]);
        $Spd->fill(['kurs' => $request->x_kurs]);
        $Spd->fill(['cacah_hotel_1' => $request->x_cacah_hotel_1]);
        $Spd->fill(['cacah_hotel_2' => $request->x_cacah_hotel_2]);
        $Spd->fill(['cacah_hotel_3' => $request->x_cacah_hotel_3]);
        $Spd->fill(['cacah_hotel_4' => $request->x_cacah_hotel_4]);

        $Spd->fill(['nonhotel_1' => $request->x_nonhotel_1]);
        $Spd->fill(['nonhotel_2' => $request->x_nonhotel_2]);
        $Spd->fill(['nonhotel_3' => $request->x_nonhotel_3]);
        $Spd->fill(['nonhotel_4' => $request->x_nonhotel_4]);

        

        $Spd->save();


        //Session::put('SuratTugas', $St);

        //$request->session()->put('SuratTugas', $St);

        return redirect()->route('spd.InputgetSpd', [$st_id])->with('status_success', 'Surat Tugas berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
