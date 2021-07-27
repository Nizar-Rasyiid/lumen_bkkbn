<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;

use App\Models\Provinsi;
//use App\Models\Kabupaten;
use App\Models\Kabupaten;
//use App\Models\V_user;
//use DB;
use Exception;

use Illuminate\Support\Facades\DB;


class KabupatenController extends Controller
{



    //provisi ################################################

public function index()
{
    return csrf_token(); 
}
    public function getKab()
    {
        $data = Kabupaten::all();

        if($data){
            $response = [
                'message'		=> 'Show Kabupaten',
                'data' 		    => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showKab($id)
    {
        $data = new Kabupaten();
        $data =  $data->select('id_Kabupaten','nama_Kabupaten','id_provinsi','KodeDepdagri',
        'IsActive','RegionalID','OriginalID','OriginalNama','OriginalKode','Created',
        'CreatedBy','LastModifiedBy','id_Kabupaten_old','nama_Kabupaten_old')
                ->find($id);
        
        try {
           if($data){
                $response = [
                    'message'		=> 'Udapte Kabupaten Sukses',
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

/*    public function createProv()
    {
        return view('datamaster.provCreate', ['id' => '','action' => 'add']);
    }
*/
    public function storeKab(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $request = json_decode($request->payload, true);

        }
        
        $this->validate($request, [

            'nama_kabupaten'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $p = new Kabupaten([
                'nama_kabupaten' => $request->input('nama_kabupaten'),
                'KodeDepdagri' => $request->input('KodeDepdagri'),
                'IsActive' => $request->input('IsActive'),
                /*'RegionalID' => $request->input('RegionalID'),
                'OriginalID' => $request->input('OriginalID'),
                'OriginalNama' => $request->input('OriginalNama'),
                'OriginalKode' => $request->input('OriginalKode'),
                'Created' => $request->input('Created'),
                'CreatedBy' => $request->input('CreatedBy'),
                'LastModified' => $request->input('LastModified'),
                'LastModifiedBy' => $request->input('LastModifiedBy'),
                'id_kabupaten_old' => $request->input('id_kabupaten_old'),
                'nama_kabupaten_old' => $request->input('nama_kabupaten_old')*/
            ]);

            $p->save();

            DB::commit();
            
            $response = [
                'message'        => 'Success',
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

    public function deleteProv($id)
    {
        DB::table('kabupaten')->where('id', $id)->delete();
//        return redirect()->route('prov');
    }
/*
    public function editProv($id)
    {
        return view('datamaster.provCreate', ['id' => $id, 'action' => 'edit']);
    }
*/
    public function updateKab(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_kabupaten=$arrDataReq["nama_kabupaten"];
            $KodeDepdagri=$arrDataReq["KodeDepdagri"];
            $IsActive=$arrDataReq["IsActive"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
        }else{

            $nama_kabupaten=$request->input["nama_kabupaten"];
            $KodeDepdagri=$request->input["KodeDepdagri"];
            $IsActive=$request->input["IsActive"];
            $id_kabupaten=$request->input["id_kabupaten"];
        }
        
  /*
        $this->validate($request, [

            'nama_kabupaten'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);
  */
        
        try {
            DB::beginTransaction();
      
            $p = Kabupaten::find($id_kabupaten);

                $p->nama_kabupaten = $nama_kabupaten;
                $p->KodeDepdagri = $KodeDepdagri;
                $p->IsActive = $IsActive;
                /*$p->RegionalID = $request->input('RegionalID');
                $p->OriginalID = $request->input('OriginalID');
                $p->OriginalNama = $request->input('OriginalNama');
                $p->OriginalKode = $request->input('OriginalKode');
                $p->Created = $request->input('Created');
                $p->CreatedBy = $request->input('CreatedBy');
                $p->LastModified = $request->input('LastModified');
                $p->LastModifiedBy = $request->input('LastModifiedBy');
                $p->id_kabupaten_old = $request->input('id_kabupaten_old');
                $p->nama_kabupaten_old = $request->input('nama_kabupaten_old');*/


            
            $p->save();
            DB::commit();

            $response = [
                'message'        => 'Update Master Kabupaten Suskses',
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
    //end prov ################################


}