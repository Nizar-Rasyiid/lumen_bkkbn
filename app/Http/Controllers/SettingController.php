<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
use App\Models\Setting;

use Exception;

use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }
    public function getSetting()
    {
        $data = DB::table('setting')
                
                ->get();



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

    public function showSetting(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama=$arrDataReq["nama"];
            $Id_kelompok_data=$arrDataReq["Id_kelompok_data"];
        }else{
            $nama=$request->input["nama"];
            $Id_kelompok_data=$request->input["Id_kelompok_data"];
        }

        $data = new Setting();
        $data= $data->select('id_setting','nama','Id_kelompok_data','value_setting','Created','CreatedBy','LastModified','LastModifiedBy')
        ->where(['nama' => $nama])
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

    public function storeSetting(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else {
            $Arryrequest["value_setting"] =$request->$request->input("value_setting");
            $Arryrequest["nama"] =$request->$request->input("nama");
            $Arryrequest["Id_kelompok_data"] =$request->$request->input("Id_kelompok_data");
        }
        try {
            DB::beginTransaction();
            
            $p = new Rt([
                'nama' => $Arryrequest['nama'],
                'Id_kelompok_data' => $Arryrequest['Id_kelompok_data'],
                'value_setting' => $Arryrequest['value_setting'],

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
    public function updateSetting(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama=$arrDataReq["nama"];
            $value_setting=$arrDataReq["value_setting"];
            $id_setting=$arrDataReq["id_setting"];
            $Id_kelompok_data=$arrDataReq["Id_kelompok_data"];
        }else{

            $nama=$request->input["nama"];
            $value_setting=$request->input["value_setting"];
            $id_setting=$request->input["id_setting"];
            $Id_kelompok_data=$request->input["Id_kelompok_data"];
        }
        
  
        
        try {
            DB::beginTransaction();
      
            $p = Rt::find($id_setting);

                $p->nama = $nama;
                $p->value_setting = $value_setting;
                $p->Id_kelompok_data = $Id_kelompok_data;
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
}
