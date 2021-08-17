<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
use App\Models\TargetKk;

use Exception;

use Illuminate\Support\Facades\DB;

class TargetKkController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    public function getTargetKk()
    {
        $data = DB::table('target_kk')
        ->join('provinsi','target_kk.id_provinsi','=','provinsi.id_provinsi')
        ->join('kabupaten','target_kk.id_kabupaten','=','kabupaten.id_kabupaten')
        ->join('kecamatan','target_kk.id_kecamatan','=','kecamatan.id_kecamatan')
        ->join('kelurahan','target_kk.id_kelurahan','=','kelurahan.id_kelurahan')
        ->join('rw','target_kk.id_rw','=','rw.id_rw')
        ->join('rt','target_kk.id_rt','=','rt.id_rw')
        ->select('target_kk.*','provinsi.nama_provinsi','kabupaten.nama_kabupaten','kecamatan.nama_kecamatan','kelurahan.nama_kelurahan','rw.nama_rw','rt.nama_rt')
        ->get();

        if($data){
            $response = [
                'message'		=> 'Show TargetKk ',
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

    public function showTargetKk(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus=$arrDataReq["Periode_Sensus"];
            $Target_KK=$arrDataReq["Target_KK"];
            $id_provinsi=$arrDataReq["id_provinsi"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
            $id_kecamatan=$arrDataReq["id_kecamatan"];
            $id_kelurahan=$arrDataReq["id_kelurahan"];
            $id_rw=$arrDataReq["id_rw"];
            $id_rt=$arrDataReq["id_rt"];
        }else{
            $Periode_Sensus=$request->input["Periode_Sensus"];
            $Target_KK=$request->input["Target_KK"];
            $id_provinsi=$request->input["id_provinsi"];
            $id_kabupaten=$request->input["id_kabupaten"];
            $id_kecamatan=$request->input["id_kecamatan"];
            $id_kelurahan=$request->input["id_kelurahan"];
            $id_rw=$request->input["id_rw"];
            $id_rt=$request->input["id_rt"];
        }

        $data = DB::table('target_kk')
        ->join('provinsi','target_kk.id_provinsi','=','provinsi.id_provinsi')
        ->join('kabupaten','target_kk.id_kabupaten','=','kabupaten.id_kabupaten')
        ->join('kecamatan','target_kk.id_kecamatan','=','kecamatan.id_kecamatan')
        ->join('kelurahan','target_kk.id_kelurahan','=','kelurahan.id_kelurahan')
        ->join('rw','target_kk.id_rw','=','rw.id_rw')
        ->join('rt','target_kk.id_rt','=','rt.id_rt')
        ->select('target_kk.*','provinsi.nama_provinsi','kabupaten.nama_kabupaten','kecamatan.nama_kecamatan','kelurahan.nama_kelurahan','rw.nama_rw','rt.nama_rt')
        ->where('target_kk.id_provinsi',
         $id_provinsi,
        'target_kk.id_kabupaten',
        $id_kabupaten,
        'target_kk.id_kecamatan',
        $id_kecamatan,
        'target_kk.id_kelurahan',
        $id_kelurahan,
        'target_kk.id_rw',
        $id_rw,
        'target_kk.id_rt',
        $id_rt)
        ->get();

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

    public function storeTargetKk(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["Periode_Sensus"] =$request->input("Periode_Sensus");
            $Arryrequest["Target_KK"] =$request->input("Target_KK");
            $Arryrequest["id_provinsi"] =$request->input("id_provinsi");
            $Arryrequest["id_kabupaten"] =$request->input("id_kabupaten");
            $Arryrequest["id_kecamatan"] =$request->input("id_kecamatan");
            $Arryrequest["id_kelurahan"] =$request->input("id_kelurahan");
            $Arryrequest["id_rw"] =$request->input("id_rw");
            $Arryrequest["id_rt"] =$request->input("id_rt");
            $Arryrequest["CreatedBy"] =$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->input("LastModifiedBy");
        }

        try {
            DB::beginTransaction();
            
            $p = new TargetKk([
                'Periode_Sensus' => $Arryrequest['Periode_Sensus'],
                'Target_KK' => $Arryrequest['Target_KK'],
                'id_provinsi'=>$Arryrequest['id_provinsi'],
                'id_kabupaten' => $Arryrequest['id_kabupaten'],
                'id_kecamatan' => $Arryrequest['id_kecamatan'],
                'id_kelurahan' => $Arryrequest['id_kelurahan'],
                'id_rw' => $Arryrequest['id_rw'],
                'id_rt' => $Arryrequest['id_rt'],
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
    public function updateTargetKk(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus=$arrDataReq["Periode_Sensus"];
            $Target_KK=$arrDataReq["Target_KK"];
            $id_provinsi=$arrDataReq["id_provinsi"];
            $id_rt=$arrDataReq["id_rt"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
            $id_kecamatan=$arrDataReq["id_kecamatan"];
            $id_kelurahan=$arrDataReq["id_kelurahan"];
            $id_rw=$arrDataReq["id_rw"];
            $LastModifiedBy=$arrDataReq["LastModifiedBy"];
        }else{

            $Periode_Sensus=$request->input["Periode_Sensus"];
            $Target_KK=$request->input["Target_KK"];
            $id_provinsi=$request->input["id_provinsi"];
            $id_rt=$request->input["id_rt"];
            $id_kabupaten=$request->input["id_kabupaten"];
            $id_kecamatan=$request->input["id_kecamatan"];
            $id_kelurahan=$request->input["id_kelurahan"];
            $id_rw=$request->input["id_rw"];
            $LastModifiedBy=$request->input["LastModifiedBy"];

        }
        
  
        
        try {
            DB::beginTransaction();
      
            $p = TargetKk::find($id_rt);

                $p->Periode_Sensus = $Periode_Sensus;
                $p->Target_KK = $Target_KK;
                $p->id_provinsi = $id_provinsi;
                $p->id_kabupaten = $id_kabupaten;
                $p->id_kecamatan = $id_kecamatan;
                $p->id_kelurahan = $id_kelurahan;
                $p->id_rw = $id_rw;
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
                'message'        => 'Update Master TargetKk Suskses',
                'data'         => $p
            ];

            return response()->json($response, 200);

        } catch (\Exception $e) {
           DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 200);
        }

        $response = [
            'message'        => 'An Error Occured'
        ];

        return response()->json($response, 200);
    }
}
