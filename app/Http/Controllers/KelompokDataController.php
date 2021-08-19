<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
use App\Models\KelompokData;

use Exception;

use Illuminate\Support\Facades\DB;

class KelompokDataController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    public function getKelompokData()
    {
        $data = DB::table('kelompok_data')
                ->get();



        if($data){
            $response = [
                'message'		=> 'Show Kel Data ',
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

    public function showKelompokData(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_kelompok_data=$arrDataReq["nama_kelompok_data"];
            $Id_kelompok_data=$arrDataReq["Id_kelompok_data"];
        }else{
            $nama_kelompok_data=$request->input["nama_kelompok_data"];
            $Id_kelompok_data=$request->input["Id_kelompok_data"];
        }

        $data = new KelompokData();
        $data= $data->select('Id_kelompok_data','nama_kelompok_data','Created','CreatedBy','LastModified','LastModifiedBy')
        ->where(['nama_kelompok_data' => $nama_kelompok_data])
        -get();

        if($data){
            $response = [
                'message'		=> 'Show rt',
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

    public function storeKelompokData(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["nama_kelompok_data"] =$request->input("nama_kelompok_data");
            $Arryrequest["CreatedBy"] =$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->input("LastModifiedBy");
        }

        try {
            DB::beginTransaction();
            
            $p = new KelompokData([
                'nama_kelompok_data' => $Arryrequest['nama_kelompok_data'],
                'CreatedBy' => $Arryrequest['CreatedBy'],
                'LastModifiedBy' => $Arryrequest['LastModifiedBy'],
            ]);
            

            $p->save();

            DB::commit();
            
            $response = [
                'message'        => 'Success',
                'data'         => $p
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 500);
        }

    }
        
    public function updateKelompokData(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_kelompok_data=$arrDataReq["nama_kelompok_data"];
            $Id_kelompok_data=$arrDataReq["Id_kelompok_data"];
            $LastModifiedBy=$arrDataReq["LastModifiedBy"];
        }else{

            $nama_kelompok_data=$request->input["nama_kelompok_data"];
            $Id_kelompok_data=$request->input["Id_kelompok_data"];
            $LastModifiedBy=$request->input["LastModifiedBy"];
        }
        
  
        
        try {
            DB::beginTransaction();
      
            $p = KelompokData::find($Id_kelompok_data);

                $p->nama_kelompok_data = $nama_kelompok_data;
                $p->Id_kelompok_data = $Id_kelompok_data;
                $p->LastModifiedBy = $LastModifiedBy;
                // $p->IsActive = $IsActive;
                /*$p->RegionalID = $request->input('RegionalID');
                $p->OriginalID = $request->input('OriginalID');
                $p->OriginalNama = $request->input('OriginalNama');
                $p->OriginalKode = $request->input('OriginalKode');
                $p->Created = $request->input('Created');
                $p->CreatedBy = $request->input('CreatedBy');
                $p->LastModified = $request->input('LastModified');
                $p->LastModifiedBy = $request->input('LastModifiedBy');
                $p->id_provinsi_old = $request->input('id_provinsi_old');
                $p->nama_provinsi_old = $request->input('nama_provinsi_old');*/


            
            $p->save();
            DB::commit();

            $response = [
                'message'        => 'Update Master rt Suskses',
                'data'         => $p
            ];

            return response()->json($response, 200);

        } catch (\Exception $e) {
           DB::rollback();
            $response = [
                'message'        => 'Transaction DB Errors',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 200);
        }

        $response = [
            'message'        => 'An Error Occured'
        ];

        return response()->json($response, 200);
    }

    public function deleteKelompokData(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Id_kelompok_data=$arrDataReq["Id_kelompok_data"];
        }else{
            $Id_kelompok_data=$request->input["Id_kelompok_data"];
        }

        $data = KelompokData::find($Id_kelompok_data);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete Kelompok Data Sukses',
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
