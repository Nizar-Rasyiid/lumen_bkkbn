<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FormKK;
use Illuminate\Support\Facades\DB;

class FormKKController extends Controller {

    public function index()
    {
        return csrf_token(); 
    }

    public function getFormKK()
    {
        $data = DB::table('table_kk_periode_sensus')
        // ->join('provinsi','table_kk_periode_sensus.id_provinsi' ,'=', 'provinsi.id_provinsi')
        // ->join('kabupaten','table_kk_periode_sensus.id_kab' ,'=', 'kabupaten.id_kabupaten')
        // ->join('kecamatan','table_kk_periode_sensus.id_kec' ,'=', 'kecamatan.id_kec')
        // ->join('kelurahan','table_kk_periode_sensus.id_kel' ,'=', 'kelurahan.id_kel')
        // ->join('rw','table_kk_periode_sensus.id_rw' ,'=', 'rw.id_rw')
        // ->join('rt','table_kk_periode_sensus.id_rt' ,'=', 'rt.id_rt')
        ->get();
        if($data){
            $response = [
                'message'		=> 'Get KK',
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

    public function showFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_provinsi = $arrDataReq["id_provinsi"];
            // $id_kab = $arrDataReq["id_kab"];
            // $id_kec = $arrDataReq["id_kec"];
            // $id_kel = $arrDataReq["id_kel"];
            // $id_rw =$arrDataReq["id_rw"];
            // $id_rt = $arrDataReq["id_rt"];

        }else{
            $id_provinsi = $request->input["id_provinsi"];
        }
        $data = DB::table('table_kk_periode_sensus')
        ->join('provinsi','table_kk_periode_sensus.id_provinsi','=','provinsi.id_provinsi')
        // ->join('kabupaten','table_kk_periode_sensus.id_kab' ,'=', 'kabupaten.id_kabupaten')
        // ->join('kecamatan','table_kk_periode_sensus.id_kec' ,'=', 'kecamatan.id_kec')
        // ->join('kelurahan','table_kk_periode_sensus.id_kel' ,'=', 'kelurahan.id_kel')
        // ->join('rw','table_kk_periode_sensus.id_rw' ,'=', 'rw.id_rw')
        // ->join('rt','table_kk_periode_sensus.id_rt' ,'=', 'rt.id_rt')
        ->select('table_kk_periode_sensus.*','provinsi.nama_provinsi')
        ->where(
        'table_kk_periode_sensus.id_provinsi', $id_provinsi,
        // 'table_kk_periode_sensus.id_kab', $id_kab,
        // 'table_kk_periode_sensus.id_kec', $id_kec,
        // 'table_kk_periode_sensus.id_kel', $id_kel,
        // 'table_kk_periode_sensus.id_rw', $id_rw,
        // 'table_kk_periode_sensus.id_rt', $id_rt,
        )
        ->get();
    
                try {
        if($data){
                $response = [
                    'message'		=> 'Update Form KK Sukses',
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
    public function storeFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["periode_sensus"] =$request->input("periode_sensus");
            $Arryrequest["NoKK"] =$request->input("NoKK");
            $Arryrequest["NIK_KK"] =$request->input("NIK_KK");
            $Arryrequest["nama_kk"] =$request->input("nama_kk");
            $Arryrequest["alamat_kk"] =$request->input("alamat_kk");
            $Arryrequest["id_provinsi"] =$request->input("id_provinsi");
            $Arryrequest["id_kab"] =$request->input("id_kab");
            $Arryrequest["id_kec"] =$request->input("id_kec");
            $Arryrequest["id_kel"] =$request->input("id_kel");
            $Arryrequest["id_rw"] =$request->input("id_rw");
            $Arryrequest["id_rt"] =$request->input("id_rt");
            $Arryrequest["CreatedBy"] =$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->input("LastModifiedBy");
        }

        try {
            DB::beginTransaction();

            $p = new FormKK([
                'periode_sensus' => $Arryrequest['periode_sensus'],
                'NoKK' => $Arryrequest['NoKK'],
                'NIK_KK' => $Arryrequest['NIK_KK'],
                'nama_kk' => $Arryrequest['nama_kk'],
                'alamat_kk' => $Arryrequest['alamat_kk'],
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
}