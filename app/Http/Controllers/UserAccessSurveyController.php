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
        ->select('user_access_survey.*','v_user.NamaLengkap','v_user.Password',"user_access_survey.id_provinsi")
        ->get();

        if($data){
            $response = [
                'message'       => 'Show UAS',
                'data'          => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'       => 'An Error Occured'
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

    public function showUAS(Request $request)
    {
        
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $UserName=$arrDataReq["UserName"];
            $password=$arrDataReq["password"];
        }else{
            $UserName=$request->input('UserName');
            $password=$request->input('password');
        }
        
        $data = new UserAccessSurvey();
    
        $data2 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 2"));
        $data =  $data->select('Password','UserName','NamaLengkap','Jabatan','NIK','Email','Alamat','id')
        ->from('v_user')
        ->where(['UserName'=>$UserName,
        'Password'=>md5($password)])->get();
        
        $data3 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 8"));
        $data4 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 9"));
        $data5 = DB::select(DB::raw("SELECT nama_provinsi,nama_kabupaten,nama_kecamatan,nama_kelurahan,nama_rw,nama_rt
        FROM (SELECT id_provinsi,id_kabupaten,id_kecamatan,id_kelurahan,id_rw,id_rt FROM user_access_survey  
        WHERE Periode_Sensus = ".$data2[0]->value_setting." AND id_user = ".$data[0]["id"].") acc_wilayah  
        inner join provinsi on acc_wilayah.id_provinsi=provinsi.id_provinsi
        inner join kabupaten on acc_wilayah.id_kabupaten=kabupaten.id_kabupaten
        inner join kecamatan on acc_wilayah.id_kecamatan=kecamatan.id_kecamatan
        inner join kelurahan on acc_wilayah.id_kelurahan=kelurahan.id_kelurahan
        inner join rw on acc_wilayah.id_rw=rw.id_rw
        inner join rt on acc_wilayah.id_rw=rt.id_rt"
        ));
        $wilayah = DB::select(DB::raw("SELECT acc_rt.id_provinsi,acc_rt.id_kabupaten,acc_rt.id_kecamatan,acc_rt.id_kelurahan,acc_rt.id_rw
         from 
        (SELECT id_provinsi,id_kabupaten,id_kecamatan,id_kelurahan,id_rw,id_rt FROM 
        user_access_survey WHERE
         id_user = ".$data[0]["id"]." AND
         Periode_Sensus = ".$data2[0]->value_setting.") 
        acc_rt INNER JOIN
         rt on 
         acc_rt.id_rt=rt.id_rt 
         GROUP BY acc_rt.id_provinsi,acc_rt.id_kabupaten,acc_rt.id_kecamatan,acc_rt.id_kelurahan,acc_rt.id_rw "));
         $rt = DB::select(DB::raw("SELECT nama_rt,acc_rt.id_rt
         FROM (SELECT id_rt FROM user_access_survey  
         WHERE Periode_Sensus = ".$data2[0]->value_setting." AND id_rw = ".$wilayah[0]->id_rw.") acc_rt INNER JOIN
         rt on 
         acc_rt.id_rt=rt.id_rt "
         ));
         
         $agama = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 4"));
         $status_nikah = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 3"));
         $jenis_kelamin = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 1"));
         $kewarganegaraan = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 10"));
         $pendidikan = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 11"));
         $status_dalam_keluarga = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 12"));
         $pekerjaan = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 13"));
         $alatKB = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 14"));
    
        
        try {
           if(count($data)==1){
               
                $response = [
                    'message'       => 'Show User Success',
                    'code'          => '00',
                    'data'          => $data,
                    'data2'         =>$data2,
                    'data3'         =>$data3,
                    'data4'         =>$data4,   
                    'wilayah'        =>$wilayah,
                    'data5'         =>$data5, 
                    'agama'             =>$agama,
                    'status_nikah'      =>$status_nikah,
                    'jenis_kelamin'     =>$jenis_kelamin,
                    'kewarganegaraan'   =>$kewarganegaraan,
                    'pendidikan'           =>$pendidikan,
                    'status_dalam_keluarga' =>$status_dalam_keluarga,
                    'pekerjaan'             =>$pekerjaan,
                    'rt'                     =>$rt, 
                    'alatKB'                 =>$alatKB
                    
                ];
                
                return response()->json($response, 200);
            }else{
                $response = [
                    'message'       => 'Login tidak sesuai',
                    'code'          => '01',
                    'data'          => $data,
                ];
    
            }
    
                return response()->json($response, 200);
    
    
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'code'          => '02',
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