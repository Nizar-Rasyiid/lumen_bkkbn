<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WebSetting;
//use App\Models\Provinsi;
// use App\Models\Provinsi;
//use App\Models\V_user;
//use DB;
use Exception;

use Illuminate\Support\Facades\DB;

class RealisasiController extends Controller
{
    public function RealisasiProv(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
        }else{
            $Periode_Sensus = $request->input["Periode_Sensus"];
        }

        $data = DB::select(DB::raw("SELECT Nama_Provinsi,
        SUM(DISTINCT(`target_kk`)) as Jumlah_KK, 
        COUNT(DISTINCT(KK.`KK_id`)) AS Jumlah_Realisasi
        FROM target_kk targets 
        LEFT JOIN provinsi prov ON prov.`id_provinsi`= targets.`id_provinsi`
        LEFT JOIN  table_kk_periode_sensus KK ON KK.`id_provinsi`=prov.`id_provinsi`
        GROUP BY targets.`periode_sensus`, prov.nama_provinsi
        HAVING Periode_Sensus = $Periode_Sensus")								
        );
    
        if($data){
            $response = [
                'message'		=> 'Show Provinsi',
                'data' 		    => $data,
            ];
        
            return response()->json($response, 200);
        }
    
        $response = [
            'message'		=> 'An Error Occured'
        ];
    
        return response()->json($response, 500);    
    }

    public function RealisasiPerProv(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
            $id_provinsi = $arrDataReq["id_provinsi"];
            // $id_kecamatan = $arrDataReq["id_kecamatan"];
        }else{
            // $id_kecamatan = $request->input["id_kecamatan"];
            $Periode_Sensus = $request->input["Periode_Sensus"];
            $id_provinsi = $request->input["$id_provinsi"];
        }

        $data = DB::select(DB::raw("SELECT Nama_Kabupaten, 
        SUM(DISTINCT(Target.Target_KK)) AS Jumlah_KK,
        COUNT(DISTINCT(KK.KK_id)) AS Jumlah_Realisasi 
        FROM target_kk Trgt 
        LEFT JOIN Kabupaten Kab ON kab.`id_kabupaten`= Trgt.`id_kabupaten` 
        LEFT JOIN table_kk_periode_sensus KK ON KK.`id_kab`=kab.`id_kabupaten`
        LEFT JOIN target_kk Target ON Target.`id_kabupaten`=kab.`id_kabupaten` 
        GROUP BY Trgt.`periode_sensus`,Trgt.`id_provinsi`,Kab.`nama_kabupaten` 
        HAVING Trgt.id_provinsi=$id_provinsi AND Trgt.Periode_Sensus=$Periode_Sensus")								
        );
    
        if($data){
            $response = [
                'message'		=> 'Show Provinsi',
                'data' 		    => $data,
            ];
        
            return response()->json($response, 200);
        }
    
        $response = [
            'message'		=> 'An Error Occured'
        ];
    
        return response()->json($response, 500);    
    }
    public function RealisasiPerKab(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
            $id_kabupaten = $arrDataReq["id_kabupaten"];
            // $id_kecamatan = $arrDataReq["id_kecamatan"];
        }else{
            // $id_kecamatan = $request->input["id_kecamatan"];
            $Periode_Sensus = $request->input["Periode_Sensus"];
            $id_kabupaten = $request->input["$id_kabupaten"];
        }
            $data = DB::select(DB::raw("SELECT Nama_Kecamatan, 
            SUM(DISTINCT(Target.Target_KK)) AS Jumlah_KK,
            COUNT(DISTINCT(KK.KK_id)) AS Jumlah_Realisasi 
            FROM target_kk Trgt 
            LEFT JOIN kecamatan kec ON kec.`id_kecamatan`= Trgt.`id_kecamatan` 
            LEFT JOIN table_kk_periode_sensus KK ON KK.`id_kec`=kec.`id_kecamatan`
            LEFT JOIN target_kk Target ON Target.`id_kecamatan`=kec.`id_kecamatan` 
            GROUP BY Trgt.`periode_sensus`,Trgt.`id_kabupaten`,kec.`nama_kecamatan` 
            HAVING Trgt.id_kabupaten=$id_kabupaten AND Trgt.Periode_Sensus=$Periode_Sensus")								
        );
    
        if($data){
            $response = [
                'message'		=> 'Show Provinsi',
                'data' 		    => $data,
            ];
        
            return response()->json($response, 200);
        }
    
        $response = [
            'message'		=> 'An Error Occured'
        ];
    
        return response()->json($response, 500);    
    }



    public function LaporanAlatKBID(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $Periode_Sensus = $arrDataReq["Periode_Sensus"];
    }else{
        $Periode_Sensus = $request->input["Periode_Sensus"];
    }

    $data = DB::select(DB::raw(
    "SELECT nama_provinsi,
    kb.alat_kontrasepsi AS alat_kb, 
    COUNT(DISTINCT(kb.data_kb_id)) AS Jumlah_Pemakai 
    FROM table_kk_periode_sensus KK 
    LEFT JOIN provinsi prov ON KK.`id_provinsi`= prov.id_provinsi 
    LEFT JOIN data_kb kb ON KK.`KK_id`= kb.KK_id 
    GROUP BY KK.`periode_sensus`, kb.alat_kontrasepsi,prov.nama_provinsi
    HAVING Periode_Sensus = $Periode_Sensus")								
    );

    if($data){
        $response = [
            'message'		=> 'Show Provinsi',
            'data' 		    => $data,
        ];
    
        return response()->json($response, 200);
    }

    $response = [
        'message'		=> 'An Error Occured'
    ];

    return response()->json($response, 500);    
    }


    public function LaporanAlatKBPerProv(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $Periode_Sensus = $arrDataReq["Periode_Sensus"];
        $id_provinsi = $arrDataReq["id_provinsi"];
    }else{
        $Periode_Sensus = $request->input["Periode_Sensus"];
        $id_provinsi = $request->input["id_provinsi"];
    }

    $data = DB::select(DB::raw(
    "SELECT nama_kabupaten,
    kb.alat_kontrasepsi AS alat_kb, 
    COUNT(DISTINCT(kb.data_kb_id)) AS Jumlah_Pemakai 
    FROM table_kk_periode_sensus KK 
    LEFT JOIN Kabupaten kab ON kab.`id_kabupaten`= KK.`id_kab` 
    LEFT JOIN data_kb kb ON KK.`KK_id`= kb.KK_id 
    GROUP BY KK.`periode_sensus`, kb.alat_kontrasepsi, KK.id_provinsi,kab.nama_kabupaten
    HAVING Periode_Sensus = $Periode_Sensus AND KK.id_provinsi = $id_provinsi
    ORDER BY kab.nama_kabupaten;
    
    ")								
    );

    if($data){
        $response = [
            'message'		=> 'Show Provinsi',
            'data' 		    => $data,
        ];
    
        return response()->json($response, 200);
    }

    $response = [
        'message'		=> 'An Error Occured'
    ];

    return response()->json($response, 500);    
    }



    public function LaporanAlatKBPerKab(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $Periode_Sensus = $arrDataReq["Periode_Sensus"];
        $id_kabupaten = $arrDataReq["id_kabupaten"];
    }else{
        $Periode_Sensus = $request->input["Periode_Sensus"];
        $id_kabupaten = $request->input["id_kabupaten"];
    }

    $data = DB::select(DB::raw(
    " SELECT nama_kecamatan,
    kb.alat_kontrasepsi AS alat_kb, 
    COUNT(DISTINCT(kb.data_kb_id)) AS Jumlah_Pemakai 
    FROM table_kk_periode_sensus KK 
    LEFT JOIN kecamatan kec ON kec.`id_kecamatan`= KK.`id_kec` 
    LEFT JOIN data_kb kb ON KK.`KK_id`= kb.KK_id 
    GROUP BY KK.`periode_sensus`, kb.alat_kontrasepsi, KK.id_kab,kec.nama_kecamatan
    HAVING Periode_Sensus = $Periode_Sensus AND KK.id_kab = $id_kabupaten")								
    );

    if($data){
        $response = [
            'message'		=> 'Show Provinsi',
            'data' 		    => $data,
        ];
    
        return response()->json($response, 200);
    }

    $response = [
        'message'		=> 'An Error Occured'
    ];

    return response()->json($response, 500);    
    }


    
}





    
