<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;

use App\Models\Kabupaten;
//use App\Models\Kecamatan;
use App\Models\Kecamatan;
//use App\Models\V_user;
//use DB;
use Exception;

use Illuminate\Support\Facades\DB;


class KecamatanController extends Controller
{



    //provisi ################################################

public function index()
{
    return csrf_token(); 
}
    public function getKec()
    {
        $data = Kecamatan::all();

        if($data){
            $response = [
                'message'		=> 'Show Kecamatan',
                'data' 		    => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showKec($id)
    {
        $data = new Kecamatan();
        $data =  $data->select('id_kecamatan','nama_kecamatan','id_kabupaten','KodeDepdagri',
        'IsActive','RegionalID','OriginalID','OriginalNama','OriginalKode','Created',
        'CreatedBy','LastModifiedBy','id_Kabupaten_old','nama_Kabupaten_old')
             ->find($id);
        
        try {
           if($data){
                $response = [
                    'message'		=> 'Udapte Kecamatan Sukses',
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
    public function storeKec(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $request = json_decode($request->payload, true);

        }
        
        $this->validate($request, [

            'nama_kecamatan'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $p = new Kecamatan([
                'nama_kecamatan' => $request->input('nama_kecamatan'),
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

    public function deleteKec($id)
    {
        DB::table('kecamatan')->where('id', $id)->delete();
//        return redirect()->route('prov');
    }
/*
    public function editProv($id)
    {
        return view('datamaster.provCreate', ['id' => $id, 'action' => 'edit']);
    }
*/
    public function updateKec(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_kecamatan=$arrDataReq["nama_kecamatan"];
            $KodeDepdagri=$arrDataReq["KodeDepdagri"];
            $IsActive=$arrDataReq["IsActive"];
            $id_kecamatan=$arrDataReq["id_kecamatan"];
        }else{

            $nama_kecamatan=$request->input["nama_kecamatan"];
            $KodeDepdagri=$request->input["KodeDepdagri"];
            $IsActive=$request->input["IsActive"];
            $id_kecamatan=$request->input["id_kecamatan"];
        }
        
  /*
        $this->validate($request, [

            'nama_kecamatan'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);
  */
        
        try {
            DB::beginTransaction();
      
            $p = Kecamatan::find($id_kecamatan);

                $p->nama_kecamatan = $nama_kecamatan;
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
                $p->id_kecamatan_old = $request->input('id_kecamatan_old');
                $p->nama_kecamatan_old = $request->input('nama_kecamatan_old');*/


            
            $p->save();
            DB::commit();

            $response = [
                'message'        => 'Update Master Kecamatan Suskses',
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