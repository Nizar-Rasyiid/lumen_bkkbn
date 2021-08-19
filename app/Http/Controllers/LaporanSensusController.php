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
        -- id_kecamatan,
        -- id_kelurahan,
        Periode_Sensus,   
        sum(target_kk) as KK,
        count(DISTINCT(id_kabupaten)) as jumKab, 
        count(DISTINCT(id_kecamatan)) as jumKec, 
        count(DISTINCT(id_kelurahan)) as jumKel 
        FROM Target_KK GROUP BY id_provinsi,Periode_Sensus
        HAVING Periode_Sensus = $Periode_Sensus
        ) target_sensus_indo
        INNER JOIN provinsi ON target_sensus_indo.id_provinsi = provinsi.id_provinsi
        -- INNER JOIN kecamatan ON  target_sensus_indo.id_kecamatan = kecamatan.id_kecamatan
        -- INNER JOIN kelurahan ON  target_sensus_indo.id_kelurahan = kelurahan.id_kelurahan
        -- INNER JOIN target_kk ON target_sensus_indo.Periode_Sensus = target_kk.Periode_Sensus
        -- WHERE target_kk.Periode_Sensus = $Periode_Sensus
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
}
