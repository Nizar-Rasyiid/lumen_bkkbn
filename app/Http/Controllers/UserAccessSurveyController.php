<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\UserAccessSurvey;

use Exception;

use Illuminate\Support\Facades\DB;

class UserAccessSurveyController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    
    public function getUAS()
    {
        $data = DB::table('user_access_survey')
        ->join('v_user','user_access_survey.id_user','=','v_user.id')
        ->select('user_access_survey.*','v_user.NamaLengkap')
        ->get();

        if($data){
            $response = [
                'message'		=> 'Show UAS',
                'data' 		    => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function storeUAS(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        $Arryrequest = json_decode(json_encode($dataReq), true);

    }else{
        $Arryrequest["id_provinsi"] =$request->$request->input("id_provinsi");
        $Arryrequest["id_kabupaten"] =$request->$request->input("id_kabupaten");
        $Arryrequest["id_kecamatan"] =$request->$request->input("id_kecamatan");
        $Arryrequest["id_kelurahan"] =$request->$request->input("id_kelurahan");
        $Arryrequest["id_rw"] =$request->$request->input("id_rw");
        $Arryrequest["id_rt"] =$request->$request->input("id_rt");
        $Arryrequest["id_user"] =$request->$request->input("id_user");
        $Arryrequest["Periode_Sensus"] =$request->$request->input("Periode_Sensus");
        $Arryrequest["CreatedBy"] =$request->$request->input("CreatedBy");
        $Arryrequest["LastModifiedBy"] =$request->$request->input("LastModifiedBy");
    }

    try {
        DB::beginTransaction();
        
        $p = new UserAccessSurvey([
            'id_provinsi' => $Arryrequest['id_provinsi'],
            'id_kabupaten' => $Arryrequest['id_kabupaten'],
            'id_kecamatan' => $Arryrequest['id_kecamatan'],
            'id_kelurahan' => $Arryrequest['id_kelurahan'],
            'id_rw' => $Arryrequest['id_rw'],
            'id_rt' => $Arryrequest['id_rt'],
            'id_user' => $Arryrequest['id_user'],
            'Periode_Sensus' => $Arryrequest['Periode_Sensus'],
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

    public function updateUAS(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id=$arrDataReq["id"];
            $id_user=$arrDataReq["id_user"];
            $id_provinsi=$arrDataReq["id_provinsi"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
            $id_kecamatan=$arrDataReq["id_kecamatan"];
            $id_kelurahan=$arrDataReq["id_kelurahan"];
            $id_rw=$arrDataReq["id_rw"];
            $id_rt=$arrDataReq["id_rt"];
            $Periode_Sensus=$arrDataReq["Periode_Sensus"];
            $LastModifiedBy=$arrDataReq["LastModifiedBy"];
        }else{
            $id=$request->input["id"];
            $id_user=$request->input["id_user"];
            $id_provinsi=$request->input["id_provinsi"];
            $id_kabupaten=$request->input["id_kabupaten"];
            $id_kecamatan=$request->input["id_kecamatan"];
            $id_kelurahan=$request->input["id_kelurahan"];
            $id_rw=$request->input["id_rw"];
            $id_rt=$request->input["id_rt"];
            $Periode_Sensus=$request->input["Periode_Sensus"];
            $LastModifiedBy=$request->input["LastModifiedBy"];
        }
        

        
        try {
            DB::beginTransaction();
    
            $p = UserAccessSurvey::find($id);

                $p->id_user = $id_user;
                $p->id_provinsi = $id_provinsi;
                $p->id_kabupaten = $id_kabupaten;
                $p->id_kecamatan = $id_kecamatan;
                $p->id_kelurahan = $id_kelurahan;
                $p->id_rw = $id_rw;
                $p->id_rt = $id_rt;
                $p->Periode_Sensus = $Periode_Sensus;
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
                'message'        => 'Update Master UAS Suskses',
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

    public function deleteUAS(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id=$arrDataReq["id"];
        }else{
            $id=$request->input["id"];
        }

        $data = UserAccessSurvey::find($id);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete UAS Sukses',
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
