<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\SuratTugas;

use App\Models\Spd;
use Session;


use PDF;

class ReportController extends Controller
{
    public function index($ids)
    {
        $atasNama = "";

        $SuratTugas_list = SuratTugas::where("id", $ids)
/*        ->with('SuratTugasUnit3')
        ->with('SuratTugasPST')
        ->with('SuratTugasTujuan1')
        ->with('SuratTugasTujuan2')
        ->with('SuratTugasTujuan')*/
        ->get();
        //var_dump($SuratTugas_list);
    }
    public function notadinas($ids)
    {
        $atasNama = "";

        $SuratTugas_list = SuratTugas::where("id", $ids)
        ->get();
        if (count($SuratTugas_list)==0) {
            return redirect()->route('IndexUser')->with('id_st', '');
        }
        //echo $SuratTugas_list[0]->SuratTugasPPK->jabatan  ;
        //if ($SuratTugas_list[0]->SuratTugasPPK->jabatan=="") {
        //   return redirect()->route('IndexUser')->with('id_st', '');
        //}
        /*        echo $SuratTugas_list->id."= st_id<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->nama ."<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->kode." kode unit eselon1<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->id." id unit eselon1<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->kode." kode unit eselon1<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->nama." Nama unit eselon1<br/>";
                echo "<br/><br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->Eselon1Kementerian->nama."<br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->PejabatEselon2->PejabatPegawai->nip." nip_pjk <br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->PejabatEselon2->PejabatPegawai->nama." nama_pjk <br/>";
                echo $SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->PejabatEselon2->PejabatPegawai->jabatan." jabatan_pjk <br/>";

                echo "<br/><br/>";
                echo $SuratTugas_list->SuratTugasPST->nip." = nip_pst <br/>";
        */
        /*        echo $SuratTugas_list->SuratTugasPST->nama." = nama_pst <br/>";
                echo $SuratTugas_list->SuratTugasPST->jabatan." = jabatan_pst<br/>";

                echo $SuratTugas_list->SuratTugasANST->nip." = id_ans <br/>";
                echo $SuratTugas_list->SuratTugasANST->nama." = nama_ans <br/>";
                echo $SuratTugas_list->SuratTugasANST->jabatan." = jabatan_ans<br/>";

        */
        //$SuratTugas_list->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->id





        $interval = getIndonesianDateInterval($SuratTugas_list[0]->tgl_brkt, $SuratTugas_list[0]->tgl_plg);
//        echo "interval=".$interval;
//        echo "<br/>". $SuratTugas_list->SuratTugasTujuan1->nama;
        $tujuan[1]=$SuratTugas_list[0]->SuratTugasTujuan1->nama;
        if ($SuratTugas_list[0]->SuratTugasTujuan2) {
            $tujuan[2]=$SuratTugas_list[0]->SuratTugasTujuan2->nama;
//            echo "<br/>". $SuratTugas_list->SuratTugasTujuan2->nama;
        }
        if ($SuratTugas_list[0]->SuratTugasTujuan3) {
            $tujuan[3]=$SuratTugas_list[0]->SuratTugasTujuan3->nama;
//            echo "<br/>". $SuratTugas_list->SuratTugasTujuan3->nama;
        }
        if ($SuratTugas_list[0]->SuratTugasTujuan4) {
            $tujuan[4]=$SuratTugas_list[0]->SuratTugasTujuan4->nama;
            //           echo "<br/>". $SuratTugas_list->SuratTugasTujuan3->nama;
        }
        $daftarTujuan = getIndonesianList($tujuan);
        //echo $daftarTujuan ;

        

        $kode_eselon_induk = $SuratTugas_list[0]->kode_eselon_induk;
        
        //$SuratTugas_list[0]->SuratTugasUnit3->Eselon3Eselon2->Eselon2Eselon1->id;//$unit['induk_eselon2'];
        /**/if ($kode_eselon_induk == "06") {
            $mengetahui_ppk = $jenis_ppk = "PPK Penunjang";
        } else {
            $mengetahui_ppk = "Pejabat Pembuat Komitmen <br />" . $SuratTugas_list[0]->nama_unit_2;//$unit['eselon2'];
            $jenis_ppk = "PPK " . $SuratTugas_list[0]->nama_unit_2;//$unit['eselon2'];
        }/**/

        $noND = str_replace("ST", "ND", $SuratTugas_list[0]->no);
        $atasNama ="";

        $arrPPK=servicePegawaiByNIP($SuratTugas_list[0]->ppk_id);
        $SuratTugas_list[0]->nipPPK=$arrPPK["nip"];
        $SuratTugas_list[0]->namaPPK=$arrPPK["nama_full"];
        $SuratTugas_list[0]->unitnamaPPK=$arrPPK["unit"];
        $SuratTugas_list[0]->jabatanPPK= $arrPPK["jabatan"];



        $arrPST=servicePegawaiByNIP($SuratTugas_list[0]->pst_id);
        $SuratTugas_list[0]->nipPST=$arrPST["nip"];
        $SuratTugas_list[0]->namaPST=$arrPST["nama_full"];
        $SuratTugas_list[0]->unitnamaPST=$arrPST["unit"];
        $SuratTugas_list[0]->jabatanPST= $arrPST["jabatan"];



        if ($SuratTugas_list[0]->anst_id!="") {
            //if ($SuratTugas_list->SuratTugasANST->nip) {
            $arrAnst=servicePegawaiByNIP($SuratTugas_list[0]->anst_id);
            //$arrAnst=

            $SuratTugas_list[0]->nipAnst=$arrAnst["nip"];
            $SuratTugas_list[0]->namaAnst=$arrAnst["nama_full"];
            $SuratTugas_list[0]->unitnamaAnst=$arrAnst["unit"];
            $SuratTugas_list[0]->jabatanAnst= $arrAnst["jabatan"];

            $atasNama = "a.n.";
            $SuratTugas_list[0]->nipPST = $SuratTugas_list[0]->nipAnst;//$st['nip_anst'];
            $SuratTugas_list[0]->namaPST = $SuratTugas_list[0]->namaAnst;
            //$st['nama_pst'] = $st['nama_anst'];
        }
        $SuratTugas_list[0]->tgl_st = getIndonesianDate($SuratTugas_list[0]->tgl_st);
        /*
                echo $SuratTugas_list[0]->SuratTugasPST->nip." = nip_pst <br/>";

                echo $SuratTugas_list[0]->SuratTugasPST->nama." = nama_pst <br/>";
                echo $SuratTugas_list[0]->SuratTugasPST->jabatan." = jabatan_pst<br/>";

                echo $SuratTugas_list[0]->SuratTugasANST->nip." = id_ans <br/>";
                echo $SuratTugas_list[0]->SuratTugasANST->nama." = nama_ans <br/>";
                echo $SuratTugas_list[0]->SuratTugasANST->jabatan." = jabatan_ans<br/>";
         */


        $Spd_list=Spd::where("st_id", $SuratTugas_list[0]->id)
        ->get();

        for ($x = 0; $x <= count($Spd_list)-1; $x++) {
            $Spd_list[$x]->noUrut=$x+1;
            if ($Spd_list[$x]->jenis_pelaksana==0) {
                $pegawai=servicePegawaiByNIP($Spd_list[$x]->pegawai_id);
                //var_dump($pegawai);
//                echo "  <br/>   ";
//                echo $pegawai["nip"]." = ";
                /* */

                $Spd_list[$x]->niptamp=$pegawai["nip"];
                $Spd_list[$x]->namatamp=$pegawai["nama_full"];
                $Spd_list[$x]->unitnama=$pegawai["unit"];
                $Spd_list[$x]->golongantamp= $pegawai["golongan"];

                $Spd_list[$x]->jabatantamp= $pegawai["jabatan"];
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
                $Spd_list[$x]->jabatantamp= $Spd_list[$x]->SpdPegawai->jabatan ;//
                $Spd_list[$x]->golongantamp= $Spd_list[$x]->SpdPegawai->PegawaiPangkat->golongan ;//

                $Spd_list[$x]->eselon= $Spd_list[$x]->SpdPegawai->PegawaiEselon->eselon;//   '
            }
        }




        
        //var_dump($SpdList);
        
        /* */

        //        echo "<br/><br/>";

        $data = array(
                    'SuratTugas_list'   => $SuratTugas_list,
                    'Spd_list'=>$Spd_list,
                   'daftarTujuan'=>$daftarTujuan,
                'atasNama'=>$atasNama,
                'mengetahui_ppk'=>$mengetahui_ppk,
                'jenis_ppk'=>$jenis_ppk,
                'noND'=>$noND,
                'interval'=>$interval

                );
        //var_dump($data);
        /* */
        $pdf = PDF::loadView('report.notadinas', $data);
        
        /**/return $pdf->setPaper('A4', 'potrait')
            ->download("Notadinas" . '_' . date("Y-m-d") . '.pdf');
    }
}
