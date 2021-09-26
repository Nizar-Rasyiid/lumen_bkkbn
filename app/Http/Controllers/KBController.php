<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KB;

class KBController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }

    public function getKB()
    {
        $data = DB::table('data_kb')
                ->get();

        if($data){
            $response = [
                'message'		=> 'Show KB',
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

    public function storeKB(Request $request)
    {
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
        
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["KK_id"] =$request->$request->input("KK_id");
            $Arryrequest["NIK"] =$request->$request->input("NIK");
            $Arryrequest["alat_kontrasepsi"] =$request->$request->input("alat_kontrasepsi");
            $Arryrequest["tahun_pemakaian"] =$request->$request->input("tahun_pemakaian");
            $Arryrequest["alasan"] =$request->$request->input("alasan");
            $Arryrequest["CreatedBy"] =$request->$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->$request->input("LastModifiedBy");
        }

        try {
            DB::beginTransaction();
            
            $p = new KB([
                'KK_id' => $Arryrequest['KK_id'],
                'NIK' => $Arryrequest['NIK'],
                'alat_kontrasepsi' => $Arryrequest['alat_kontrasepsi'],
                'tahun_pemakaian' => $Arryrequest['tahun_pemakaian'],
                'alasan' => $Arryrequest['alasan'],
                'CreatedBy' => $Arryrequest['CreatedBy'],
                'LastModifiedBy' => $Arryrequest['LastModifiedBy'],
            ]);

            $p->save();

            DB::commit();
            
            $response = [
                'message'        => 'Input Data Sukses',
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
    
    public function deleteKB(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $data_kb_id=$arrDataReq["data_kb_id"];
        }else{
            $data_kb_id=$request->input["data_kb_id"];
        }

        $data = KB::find($data_kb_id);
        try {
            if($data->delete()){
                 $response = [
                     'message'      => 'Delete KB Sukses',
                     'data'             => $data,
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

    public function updateKB(Request $request)
    {

    }
}
