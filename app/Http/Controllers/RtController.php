<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
use App\Models\Rt;

use Exception;

use Illuminate\Support\Facades\DB;

class RtController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    public function getRt()
    {
        $data = DB::table('rt')
                ->join('rw','rt.id_rw','=','rw.id_rw')
                ->join('kelurahan','rw.id_kelurahan','=','kelurahan.id_kelurahan')
                ->join('kecamatan','kelurahan.id_kecamatan','=','kecamatan.id_kecamatan')
                ->join('kabupaten','kecamatan.id_kabupaten','=','kabupaten.id_kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('rt.*','rw.nama_rw','rw.id_kelurahan','nama_kelurahan','rw.id_rw','kelurahan.id_kecamatan','nama_kecamatan','kelurahan.id_kelurahan','kecamatan.id_kabupaten','nama_kabupaten','kecamatan.id_kecamatan','kabupaten.id_provinsi','nama_provinsi','kabupaten.id_kabupaten')
                ->get();

                // $data_json = json_decode($data, true);
                // $array_rw_kota_provinsi_id = array();
                // foreach ($data_json as $key=>$value) {
                //     echo($key. ' ');
                    
                //     foreach ($value as $key2=>$value2) {
                //             $valueProvinsi = $value;
                //         if ($key=='rw_kota_provinsi_i_d') {
                //             if ($key2 =='nama_provinsi') {
                //                 $valueProvinsi = $value2;
                //             }
                //         }
                //     }
                //     $value = $valueProvinsi;
                //     $array_rw_kota_provinsi_id[$key]=$value;    
                // }
                
                // var_dump($array_rw_kota_provinsi_id);
                // die();

        if($data){
            $response = [
                'message'		=> 'Show RT ',
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

    public function showRt(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_rw=$arrDataReq["id_rw"];
        }else{
            $id_rw=$request->input["id_rw"];
        }

        $data = DB::table('rt')
                ->join('rw','rt.id_rw','=','rw.id_rw')
                ->select('rt.*','rw.nama_rw')
                ->where('rt.id_rw', $id_rw)
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

    public function storeRt(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else {
            $Arryrequest["KodeRT"] =$request->$request->input("KodeRT");
            $Arryrequest["nama_rt"] =$request->$request->input("nama_rt");
            $Arryrequest["id_rw"] =$request->$request->input("id_rw");
            $Arryrequest["IsActive"] =$request->$request->input("IsActive");
            $Arryrequest["CreatedBy"] =$request->$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->$request->input("LastModifiedBy");
        }
        // $this->validate($request, [

        //     'nama_provinsi'   => 'required',
        //     'KodeDepdagri'   => 'required',
        //     'IsActive'   => 'required',
        // ]);

        try {
            DB::beginTransaction();
            
            $p = new Rt([
                'nama_rt' => $Arryrequest['nama_rt'],
                'id_rw' => $Arryrequest['id_rw'],
                'KodeRT' => $Arryrequest['KodeRT'],
                'IsActive' => $Arryrequest['IsActive'],
                'CreatedBy' => $Arryrequest['CreatedBy'],
                'LastModifiedBy' => $Arryrequest['LastModifiedBy'],
                /*'RegionalID' => $request->input('RegionalID'),
                'OriginalID' => $request->input('OriginalID'),
                'OriginalNama' => $request->input('OriginalNama'),
                'OriginalKode' => $request->input('OriginalKode'),
                'Created' => $request->input('Created'),
                'CreatedBy' => $request->input('CreatedBy'),
                'LastModified' => $request->input('LastModified'),
                'LastModifiedBy' => $request->input('LastModifiedBy'),
                'id_provinsi_old' => $request->input('id_provinsi_old'),
                'nama_provinsi_old' => $request->input('nama_provinsi_old')*/
            ]);

            $p->save();

            DB::commit();
            
            $response = [
                'message'        => 'Success simpan Data RT',
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
    public function updateRt(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_rt=$arrDataReq["nama_rt"];
            $KodeRT=$arrDataReq["KodeRT"];
            $id_rw=$arrDataReq["id_rw"];
            $id_rt=$arrDataReq["id_rt"];
            $IsActive=$arrDataReq["IsActive"];
            $LastModifiedBy=$arrDataReq["LastModifiedBy"];
        }else{

            $nama_rt=$request->input["nama_rt"];
            $KodeRT=$request->input["KodeRT"];
            $id_rw=$request->input["id_rw"];
            $id_rt=$request->input["id_rt"];
            $IsActive=$request->input["IsActive"];
            $LastModifiedBy=$request->input["LastModifiedBy"];
        }
        
  
        
        try {
            DB::beginTransaction();
      
            $p = Rt::find($id_rt);

                $p->nama_rt = $nama_rt;
                $p->KodeRT = $KodeRT;
                $p->id_rw = $id_rw;
                $p->IsActive = $IsActive;
                $p->LastModifiedBy = $LastModifiedBy;
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
                'message'        => 'Update Master Rt Suskses',
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

    public function deleteRt(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_rt=$arrDataReq["id_rt"];
        }else{
            $id_rt=$request->input["id_rt"];
        }

        $data = Rt::find($id_rt);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete Rt Sukses',
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
