<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kelurahan;
use Illuminate\Support\Facades\DB;

class KelurahanController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }

    public function getKel()
    {
        $data = Kelurahan::all();

        if($data){
            $response = [
                'message'		=> 'Show Kelurahan',
                'data' 		    => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showKel($id)
    {
        $data = new Kelurahan();
        $data =  $data->select('id_kelurahan','nama_kelurahan','KodeDepdagri','nama_kecamatan','id_kecamatan',
        'IsActive','OriginalID','OriginalNama','OriginalKode','Created',
        'CreatedBy','LastModifiedBy','id_kecamatan_old','nama_kelurahan_old')
                ->find($id);
        
        try {
           if($data){
                $response = [
                    'message'		=> 'Update Kelurahan Sukses',
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

    public function storeKel(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["nama_kelurahan"] =$request->$request->input("nama_kelurahan");
            $Arryrequest["nama_kecamatan"] =$request->$request->input("nama_kecamatan");
            $Arryrequest["id_kecamatan"] =$request->$request->input("id_kecamatan");
            $Arryrequest["KodeDepdagri"] =$request->$request->input("KodeDepdagri");
            $Arryrequest["IsActive"] =$request->$request->input("IsActive");
        }
        echo json_encode($Arryrequest);
        //console.log($Arryrequest)
/*        $this->validate($Arryrequest, [
            'nama_provinsi'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);*/

        try {
            DB::beginTransaction();
            
            $p = new Kelurahan([
                'nama_kelurahan' => $Arryrequest['nama_kelurahan'],
                'nama_kecamatan' => $Arryrequest['nama_kecamatan'],
                'id_kecamatan' => $Arryrequest['id_kecamatan'],
                'KodeDepdagri' => $Arryrequest['KodeDepdagri'],
                'IsActive' => $Arryrequest['IsActive'],
                /*'RegionalID' => $request->input('RegionalID'),
                'OriginalID' => $request->input('OriginalID'),
                'OriginalNama' => $request->input('OriginalNama'),
                'OriginalKode' => $request->input('OriginalKode'),
                'Created' => $request->input('Created'),
                'CreatedBy' => $request->input('CreatedBy'),
                'LastModified' => $request->input('LastModified'),
                'LastModifiedBy' => $request->input('LastModifiedBy'),
                'id_kecamatan_old' => $request->input('id_kecamatan_old'),
                'nama_provinsi_old' => $request->input('nama_provinsi_old')*/
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

    public function deleteKel($id)
    {
        $kel = Kelurahan::where('id_kelurahan', $id)->first();
        if ($kel->delete()) {
            print("berhasil delete");
        }else{
            print("gagal delete");
        }
//        return redirect()->route('prov');
    }
/*
    public function editProv($id)
    {
        return view('datamaster.provCreate', ['id' => $id, 'action' => 'edit']);
    }
*/
    public function updateKel(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $nama_kelurahan=$arrDataReq["nama_kelurahan"];
            $id_kelurahan=$arrDataReq["id_kelurahan"];
            $KodeDepdagri=$arrDataReq["KodeDepdagri"];
            $IsActive=$arrDataReq["IsActive"];
            $nama_kecamatan=$arrDataReq["nama_kecamatan"];
            $id_kecamatan=$arrDataReq["id_kecamatan"];
        }else{

            $nama_kelurahan=$request->input["nama_kelurahan"];
            $id_kecamatan=$request->input["id_kecamatan"];
            $KodeDepdagri=$request->input["KodeDepdagri"];
            $IsActive=$request->input["IsActive"];
            $nama_kecamatan=$arrDataReq["nama_kecamatan"];
            $id_kelurahan=$request->input["id_kelurahan"];
        }
        
  /*
        $this->validate($request, [
            'nama_provinsi'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);
  */
        
        try {
            DB::beginTransaction();
      
            $p = Kelurahan::find($id_kelurahan);

                $p->nama_kelurahan = $nama_kelurahan;
                $p->nama_kecamatan = $nama_kecamatan;
                $p->id_kecamatan = $id_kecamatan;
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
                $p->nama_provinsi_old = $request->input('nama_provinsi_old');*/


            
            $p->save();
            DB::commit();

            $response = [
                'message'        => 'Update Master kelurahan Suskses',
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