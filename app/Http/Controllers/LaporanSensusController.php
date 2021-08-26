<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\TargetKk;

use Illuminate\Support\Facades\DB;

class LaporanSensusController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }

    public function showLaporanSensusID(Request $request)
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

        $data = DB::select(DB::raw("SELECT provinsi.nama_provinsi,
        target_sensus_indo.KK,
        target_sensus_indo.jumKab, 
        target_sensus_indo.jumKec, 
        target_sensus_indo.jumKel
        FROM (SELECT 
        id_provinsi,
        Periode_Sensus,   
        sum(target_kk) as KK,
        count(DISTINCT(id_kabupaten)) as jumKab, 
        count(DISTINCT(id_kecamatan)) as jumKec, 
        count(DISTINCT(id_kelurahan)) as jumKel 
        FROM Target_KK GROUP BY id_provinsi,Periode_Sensus
        HAVING Periode_Sensus = $Periode_Sensus
        ) target_sensus_indo
        INNER JOIN provinsi ON target_sensus_indo.id_provinsi = provinsi.id_provinsi
        "
        ));

            try {
                if($data){
                     $response = [
                         'message'		=> 'Show Sensus Success',
                         'data' 		    => $data,
                     ];
     
                     return response()->json($response, 200);
                 }
     
     
     
             } catch (\Exception $e) {
                 DB::rollback();
                 $response = [
                     'message'        => 'Transaction DB Error',
                     'data'      => $e->getMessage()
                 ];
                 return response()->json($response, 500);
             }
        
    }

    public function showLaporanSensusPerProv(Request $request)
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

    $data = DB::select(DB::raw("SELECT 
        kabupaten.nama_kabupaten,
        target_sensus_indo.KK,
        target_sensus_indo.jumKec, 
        target_sensus_indo.jumKel
        FROM (SELECT 
        id_provinsi,
        id_kabupaten,
        Periode_Sensus,   
        sum(target_kk) as KK,
        count(DISTINCT(id_kecamatan)) as jumKec, 
        count(DISTINCT(id_kelurahan)) as jumKel 
        FROM Target_KK GROUP BY id_provinsi,id_kabupaten,Periode_Sensus
        HAVING Periode_Sensus = $Periode_Sensus
        ) target_sensus_indo
        INNER JOIN provinsi ON target_sensus_indo.id_provinsi = provinsi.id_provinsi
        INNER JOIN kabupaten ON target_sensus_indo.id_kabupaten = kabupaten.id_kabupaten
        WHERE provinsi.id_provinsi = $id_provinsi
    "
        )
    );
    
    if($data){
        $response = [
            'message'		=> 'Show Kabupaten',
            'data' 		    => $data,
        ];

        // echo(response()->json(data));
        return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showLaporanSensusPerKab(Request $request)
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

    $data = DB::select(DB::raw("SELECT 
    kecamatan.nama_kecamatan, 
    target_sensus_indo.KK, 
    target_sensus_indo.jumKel 
    FROM (SELECT 
    id_kecamatan,
    id_kabupaten, 
    Periode_Sensus, 
    sum(target_kk) as KK, 
    count(DISTINCT(id_kelurahan)) as jumKel 
    FROM Target_KK GROUP BY id_kecamatan,Periode_Sensus,id_kabupaten 
    HAVING Periode_Sensus = $Periode_Sensus ) target_sensus_indo 
    INNER JOIN kecamatan ON target_sensus_indo.id_kecamatan = kecamatan.id_kecamatan 
    INNER JOIN kabupaten ON target_sensus_indo.id_kabupaten = kabupaten.id_kabupaten 
    WHERE kabupaten.id_kabupaten = $id_kabupaten
    "
        )
    );
    
    if($data){
        $response = [
            'message'		=> 'Show Kabupaten',
            'data' 		    => $data,
        ];

        // echo(response()->json(data));
        return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showLaporanSensusPerKec(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
            $id_kecamatan = $arrDataReq["id_kecamatan"];
        }else{
            $Periode_Sensus = $request->input["Periode_Sensus"];
            $id_kecamatan = $request->input["id_kecamatan"];
        }

        $data = DB::select(DB::raw("SELECT kelurahan.nama_kelurahan,
        target_sensus_indo.KK
        FROM (SELECT 
        id_kecamatan,
        id_kelurahan,
        Periode_Sensus,   
        sum(target_kk) as KK
        FROM Target_KK GROUP BY id_kecamatan,id_kelurahan,Periode_Sensus
        HAVING Periode_Sensus = $Periode_Sensus
        ) target_sensus_indo
        INNER JOIN kecamatan ON target_sensus_indo.id_kecamatan = kecamatan.id_kecamatan
        INNER JOIN kelurahan ON target_sensus_indo.id_kelurahan = kelurahan.id_kelurahan
        WHERE kecamatan.id_kecamatan = $id_kecamatan"
            )
        );
        
        if($data){
            $response = [
                'message'		=> 'Show Kecamatan',
                'data' 		    => $data,
            ];

            // echo(response()->json(data));
            return response()->json($response, 200);
            }

            $response = [
                'message'		=> 'An Error Occured'
            ];

            return response()->json($response, 500);
    }

    public function showLaporanSensusPerKel(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
            $id_kelurahan = $arrDataReq["id_kelurahan"];
        }else{
            $Periode_Sensus = $request->input["Periode_Sensus"];
            $id_kelurahan = $request->input["id_kelurahan"];
        }

        $data = DB::select(DB::raw("SELECT 
        target_sensus_indo.KK,
        target_sensus_indo.jumRW, 
        target_sensus_indo.jumRT
        FROM (SELECT 
        id_kelurahan,
        Periode_Sensus,   
        sum(target_kk) as KK,
        count(DISTINCT(id_rw)) as jumRW, 
        count(DISTINCT(id_rt)) as jumRT 
        FROM Target_KK GROUP BY id_kelurahan,Periode_Sensus
        HAVING Periode_Sensus = $Periode_Sensus
        ) target_sensus_indo
        INNER JOIN kelurahan ON target_sensus_indo.id_kelurahan = kelurahan.id_kelurahan
        WHERE kelurahan.id_kelurahan = $id_kelurahan"
        )
        );

        if($data){
            $response = [
                'message'		=> 'Laporan PerKelurahan',
                'data' 		    => $data,

            ];
            // var_dump($response);
            return response()->json($response, 200);

        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }
}
