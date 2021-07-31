<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kabupaten;
use Illuminate\Support\Facades\DB;

class KabupatenController extends Controller
{
        public function index()
    {
        return csrf_token(); 
    }

    public function getKab()
    {
        $data = DB::table('kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('kabupaten.*','provinsi.nama_provinsi')
                ->get();

                // $data_json = json_decode($data, true);
                // $array_kabupaten_kota_provinsi_id = array();
                // foreach ($data_json as $key=>$value) {
                //     echo($key. ' ');
                    
                //     foreach ($value as $key2=>$value2) {
                //             $valueProvinsi = $value;
                //         if ($key=='kabupaten_kota_provinsi_i_d') {
                //             if ($key2 =='nama_provinsi') {
                //                 $valueProvinsi = $value2;
                //             }
                //         }
                //     }
                //     $value = $valueProvinsi;
                //     $array_kabupaten_kota_provinsi_id[$key]=$value;    
                // }
                
                // var_dump($array_kabupaten_kota_provinsi_id);
                // die();

        if($data){
            $response = [
                'message'		=> 'Show kabupaten',
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

    public function showKab(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_provinsi=$arrDataReq["id_provinsi"];
        }else{
            $id_provinsi=$request->input["id_provinsi"];
        }

        $data = DB::table('kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('kabupaten.*','provinsi.nama_provinsi')
                ->where('kabupaten.id_provinsi', $id_provinsi)
                ->get();

        if($data){
            $response = [
                'message'		=> 'Show kabupaten',
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

    public function storeKab(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["nama_kabupaten"] =$request->$request->input("nama_kabupaten");
            $Arryrequest["id_provinsi"] =$request->$request->input("id_provinsi");
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
            
            $p = new Kabupaten([
                'nama_kabupaten' => $Arryrequest['nama_kabupaten'],
                'id_provinsi' => $Arryrequest['id_provinsi'],
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
                'id_provinsi_old' => $request->input('id_provinsi_old'),
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

    public function deleteKab($id)
    {
        $kab = Kabupaten::where('id_kabupaten', $id)->first();
        if ($kab->delete()) {
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
            $id_provinsi=$arrDataReq["id_provinsi"];
            $KodeDepdagri=$arrDataReq["KodeDepdagri"];
            $IsActive=$arrDataReq["IsActive"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
        }else{

            $nama_kabupaten=$request->input["nama_kabupaten"];
            $id_provinsi=$request->input["id_provinsi"];
            $KodeDepdagri=$request->input["KodeDepdagri"];
            $IsActive=$request->input["IsActive"];
            $id_kabupaten=$request->input["id_kabupaten"];
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
      
            $p = Kabupaten::find($id_kabupaten);

                $p->nama_kabupaten = $nama_kabupaten;
                $p->id_provinsi = $id_provinsi;
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
                $p->id_provinsi_old = $request->input('id_provinsi_old');
                $p->nama_provinsi_old = $request->input('nama_provinsi_old');*/


            
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
}
