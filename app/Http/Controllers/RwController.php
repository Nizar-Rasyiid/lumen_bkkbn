<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
use App\Models\Rw;

use Exception;

use Illuminate\Support\Facades\DB;

class RwController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    public function getRw()
    {
        $data = DB::table('rw')
                ->join('kelurahan','rw.id_kelurahan','=','kelurahan.id_kelurahan')
                ->join('kecamatan','kelurahan.id_kecamatan','=','kecamatan.id_kecamatan')
                ->join('kabupaten','kecamatan.id_kabupaten','=','kabupaten.id_kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('rw.*','kelurahan.nama_kelurahan','kelurahan.id_kecamatan','nama_kecamatan','kelurahan.id_kelurahan','kecamatan.id_kabupaten','nama_kabupaten','kecamatan.id_kecamatan','kabupaten.id_provinsi','nama_provinsi','kabupaten.id_kabupaten')
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
                'message'		=> 'Show RW ',
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

    public function showRw(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_kelurahan=$arrDataReq["id_kelurahan"];
        }else{
            $id_kelurahan=$request->input["id_kelurahan"];
        }

        $data = DB::table('rw')
                ->join('kelurahan','rw.id_kelurahan','=','kelurahan.id_kelurahan')
                ->select('rw.*','kelurahan.nama_kelurahan')
                ->where('rw.id_kelurahan', $id_kelurahan)
                ->get();

        if($data){
            $response = [
                'message'		=> 'Show rw',
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

        public function storeRw(Request $request)
        {
             if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
                && $request->isJson()
            ) {
                $dataReq = $request->json()->all();
                $Arryrequest = json_decode(json_encode($dataReq), true);
    
            }else {
                $Arryrequest["nama_rw"] =$request->$request->input("nama_rw");
                $Arryrequest["KodeDepdagri"] =$request->$request->input("KodeDepdagri");
                $Arryrequest["id_kelurahan"] =$request->$request->input("id_kelurahan");
                $Arryrequest["IsActive"] =$request->$request->input("IsActive");
                $Arryrequest["CreatedBy"] =$request->$request->input("CreatedBy");
                $Arryrequest["LastModifiedBy"] =$request->$request->input("LastModifiedBy");
            }
            // echo json_encode($Arryrequest);
            // $this->validate($request, [
    
            //     'nama_provinsi'   => 'required',
            //     'KodeDepdagri'   => 'required',
            //     'IsActive'   => 'required',
            // ]);
    
            try {
                DB::beginTransaction();
                
                $p = new Rw([
                    'nama_rw' => $Arryrequest['nama_rw'],
                    'KodeDepdagri' => $Arryrequest['KodeDepdagri'],
                    'id_kelurahan' => $Arryrequest['id_kelurahan'],
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
                    'message'        => 'Success simpan Data Rw',
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

        public function updateRw(Request $request)
        {
    
            //
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
                && $request->isJson()
            ) {
                $dataReq = $request->json()->all();
                //json_decode($dataReq, true);
                $arrDataReq =json_decode(json_encode($dataReq),true);
                $KodeDepdagri=$arrDataReq["KodeDepdagri"];
                $id_kelurahan=$arrDataReq["id_kelurahan"];
                $nama_rw=$arrDataReq["nama_rw"];
                $IsActive=$arrDataReq["IsActive"];
                $id_rw=$arrDataReq["id_rw"];
                $LastModifiedBy=$arrDataReq["LastModifiedBy"];
            }else{
    
                $KodeDepdagri=$request->input["KodeDepdagri"];
                $id_kelurahan=$request->input["id_kelurahan"];
                $nama_rw=$request->input["nama_rw"];
                $IsActive=$request->input["IsActive"];
                $id_rw=$request->input["id_rw"];
                $LastModifiedBy=$request->input["LastModifiedBy"];
            }
            
      
            
            try {
                DB::beginTransaction();
          
                $p = Rw::find($id_rw);
    
                    $p->nama_rw = $nama_rw;
                    $p->KodeDepdagri = $KodeDepdagri;
                    $p->id_kelurahan = $id_kelurahan;
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
                    'message'        => 'Update Master Rw Sukses',
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
    
    public function deleteRw(Request $request)
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

        $data = Rw::find($id_rw);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete Rw Sukses',
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