<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
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
        sum(`target_kk`) as Jumlah_KK, 
        COUNT(DISTINCT(KK.`KK_id`)) AS Jumlah_Realisasi
        FROM target_kk Trgt 
        LEFT JOIN provinsi prov ON prov.`id_provinsi`= Trgt.`id_provinsi`
        LEFT JOIN  table_kk_periode_sensus KK ON KK.`id_provinsi`=Prov.`id_provinsi`
        GROUP BY Trgt.`periode_sensus`,prov.`nama_provinsi`
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

    public function RealisasiPerProv()
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
        sum(Target.`target_kk`) as Jumlah_KK, 
        COUNT(DISTINCT(KK.`KK_id`)) AS Jumlah_Realisasi
        FROM target_kk Trgt 
        LEFT JOIN provinsi prov ON prov.`id_provinsi`= Trgt.`id_provinsi`
        LEFT JOIN Kabupaten Kab ON kab.`id_provinsi`= Prov.`id_provinsi`
        LEFT JOIN  table_kk_periode_sensus KK ON KK.`id_kab`=kab.`id_kabupaten`
        LEFT JOIN  target_kk Target ON Target.`id_kabupaten`=kab.`id_kabupaten`
        GROUP BY Trgt.`periode_sensus`,Prov.`id_provinsi`,Kab.`nama_kabupaten`
        HAVING Prov.`id_provinsi`=$id_provinsi AND Trgt.`periode_sensus`=$Periode_Sensus")								
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
    public function RealisasiPerKab()
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
        sum(`target_kk`) as Jumlah_KK, 
        COUNT(DISTINCT(KK.`KK_id`)) AS Jumlah_Realisasi
        FROM target_kk Trgt 
        LEFT JOIN kabupaten kab ON kab.`id_kabupaten`= Trgt.`id_kabupaten`
        LEFT JOIN kecamatan kec ON kec.`id_kabupaten`= kab.`id_kabupaten`
        LEFT JOIN  table_kk_periode_sensus KK ON KK.`id_kec`=kec.`id_kecamatan`
        GROUP BY Trgt.`periode_sensus`,Kab.`id_kabupaten`,Kec.`nama_kecamatan`
        HAVING kab.`id_kabupaten`=5 AND Trgt.`periode_sensus`=2021")								
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