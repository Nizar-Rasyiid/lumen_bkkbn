<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FormKK;

use Exception;
use Illuminate\Support\Facades\DB;

class FormKKController extends Controller {

    public function index()
    {
        return csrf_token(); 
    }

    public function getFormKK()
    {
        $data = DB::table('table_kk_periode_sensus')
        ->join('provinsi','table_kk_periode_sensus.id_provinsi' ,'=', 'provinsi.id_provinsi')
        ->join('kabupaten','table_kk_periode_sensus.id_kab' ,'=', 'kabupaten.id_kabupaten')
        ->join('kecamatan','table_kk_periode_sensus.id_kec' ,'=', 'kecamatan.id_kecamatan')
        ->join('kelurahan','table_kk_periode_sensus.id_kel' ,'=', 'kelurahan.id_kelurahan')
        ->join('rw','table_kk_periode_sensus.id_rw' ,'=', 'rw.id_rw')
        ->join('rt','table_kk_periode_sensus.id_rt' ,'=', 'rt.id_rt')
        ->select('table_kk_periode_sensus.*','nama_rt','nama_rw','nama_kelurahan','nama_kecamatan','nama_kabupaten','nama_provinsi')
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
    public function getIdKK()
    {
        $data = DB::select(DB::raw("SELECT KK_id,NIK_KK FROM table_kk_periode_sensus ORDER BY KK_id DESC LIMIT 1"
    )
        );
       if($data){
        $response = [
            'message'		=> 'Get Id KK',
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
            $Arryrequest["NoKK"] =$request->$request->input("NoKK");
            $Arryrequest["NIK_KK"] =$request->$request->input("NIK_KK");
            $Arryrequest["nama_kk"] =$request->$request->input("nama_kk");
            $Arryrequest["alamat_kk"] =$request->$request->input("alamat_kk");
            $Arryrequest["id_provinsi"] =$request->$request->input("id_provinsi");
            $Arryrequest["id_kab"] =$request->$request->input("id_kab");
            $Arryrequest["id_kec"] =$request->$request->input("id_kec");
            $Arryrequest["id_kel"] =$request->$request->input("id_kel");
            $Arryrequest["id_rw"] =$request->$request->input("id_rw");
            $Arryrequest["id_rt"] =$request->$request->input("id_rt");
            $Arryrequest["create_by"] =$request->$request->input("create_by");
            $Arryrequest["update_by"] =$request->$request->input("update_by");
        }

        try {
            DB::beginTransaction();

            $p = new FormKK([
                'periode_sensus' => $Arryrequest['periode_sensus'],
                'NoKK' => $Arryrequest['NoKK'],
                'NIK_KK' => $Arryrequest['NIK_KK'],
                'nama_kk' => $Arryrequest['nama_kk'],
                'alamat_kk' => $Arryrequest['alamat_kk'],
                'id_provinsi' => $Arryrequest['id_provinsi'],
                'id_kab' => $Arryrequest['id_kab'],
                'id_kec' => $Arryrequest['id_kec'],
                'id_kel' => $Arryrequest['id_kel'],
                'id_rw' => $Arryrequest['id_rw'],
                'id_rt' => $Arryrequest['id_rt'],
                'create_by' => $Arryrequest['create_by'],
                'update_by' => $Arryrequest['update_by'],
            ]);

            $p->save();

            DB::commit();
        
            $response = [
                'message'        => 'Input Data Sukses',
                'data'         => $p
            ];

            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function updateFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $KK_id=$arrDataReq["KK_id"];
            $periode_sensus=$arrDataReq["periode_sensus"];
            $NoKK=$arrDataReq["NoKK"];
            $NIK_KK=$arrDataReq["NIK_KK"];
            $nama_kk=$arrDataReq["nama_kk"];
            $alamat_kk=$arrDataReq["NoKK"];
            $id_provinsi=$arrDataReq["id_provinsi"];
            $id_kab=$arrDataReq["id_kab"];
            $id_kec=$arrDataReq["id_kec"];
            $id_kel=$arrDataReq["id_kel"];
            $id_rw=$arrDataReq["id_rw"];
            $id_rt=$arrDataReq["id_rt"];
            $update_by=$arrDataReq["update_by"];
        }else{
            $KK_id=$request->input["KK_id"];
            $NoKK=$request->input["NoKK"];
            $NIK_KK=$arrDataReq["NIK_KK"];
            $nama_kk=$arrDataReq["nama_kk"];
            $alamat_kk=$arrDataReq["NoKK"];
            $id_provinsi=$request->input["id_provinsi"];
            $id_kab=$request->input["id_kab"];
            $id_kec=$request->input["id_kec"];
            $id_kel=$request->input["id_kel"];
            $id_rw=$request->input["id_rw"];
            $id_rt=$request->input["id_rt"];
            $periode_sensus=$arrDataReq["periode_sensus"];
            $update_by=$request->input["update_by"];
        }
        

        
        try {
            DB::beginTransaction();
    
            $p = FormKK::find($KK_id);

                $p->periode_sensus = $periode_sensus;
                $p->NoKK = $NoKK;
                $p->NIK_KK = $NIK_KK;
                $p->nama_kk = $nama_kk;
                $p->alamat_kk = $alamat_kk;
                $p->id_provinsi = $id_provinsi;
                $p->id_kab = $id_kab;
                $p->id_kec = $id_kec;
                $p->id_kel = $id_kel;
                $p->id_rw = $id_rw;
                $p->id_rt = $id_rt;
                $p->update_by = $update_by;
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
                'message'        => 'Update Form KK Suskses',
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

    public function deleteFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $KK_id=$arrDataReq["KK_id"];
        }else{
            $KK_id=$request->input["KK_id"];
        }

        $data = FormKK::find($KK_id);
        try {
            if($data->delete()){
                 $response = [
                     'message'      => 'Delete UAS Sukses',
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
}