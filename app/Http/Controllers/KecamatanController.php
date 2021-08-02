<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }

    public function getKec()
    {
        $data = DB::table('kecamatan')
                ->join('kabupaten','kecamatan.id_kabupaten','=','kabupaten.id_kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('kecamatan.*','kabupaten.nama_kabupaten','provinsi.nama_provinsi',)
                ->get();
                // var_dump($data);
        // $data = new Kecamatan();
        // $data =  $data->select('id_kecamatan','nama_kecamatan','KodeDepdagri',
        // 'IsActive','OriginalID','OriginalNama','OriginalKode','Created',
        // 'CreatedBy','LastModifiedBy','id_kecamatan_old','nama_kecamatan_old')
        //         ->with('KabupatenKotaKecamatanId')
        //         ->get();


        if($data){
            $response = [
                'message'		=> 'Show Kecamatan',
                'data' 		    => $data,

            ];
            // var_dump($response);
            return response()->json($response, 200);

        }

        $response = [
            'message'		=> 'An Error Occured'
        ];

        return response()->json($response, 500);
    }

    public function showKec(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_kabupaten = $arrDataReq["id_kabupaten"];
        }else{
            $id_kabupaten = $request->input["id_kabupaten"];
        }

        $data = DB::table('kecamatan')
        ->join('kabupaten','kecamatan.id_kabupaten','=','kabupaten.id_kabupaten')
        ->select('kecamatan.*','kabupaten.nama_kabupaten')
        ->where('kecamatan.id_kabupaten', $id_kabupaten)
        ->get();

        
        try {
           if($data){
                $response = [
                    'message'		=> 'Update Kecamatan Sukses',
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

    public function storeKec(Request $request)
    {
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["nama_kecamatan"] =$request->$request->input("nama_kecamatan");
            $Arryrequest["id_kabupaten"] =$request->$request->input("id_kabupaten");
            $Arryrequest["KodeDepdagri"] =$request->$request->input("KodeDepdagri");
            $Arryrequest["IsActive"] =$request->$request->input("IsActive");
        }
        echo json_encode($Arryrequest);
        //console.log($Arryrequest)
/*        $this->validate($Arryrequest, [

            'nama_kabupaten'   => 'required',
            'KodeDepdagri'   => 'required',
            'IsActive'   => 'required',
        ]);*/

        try {
            DB::beginTransaction();
            
            $p = new Kecamatan([
                'nama_kecamatan' => $Arryrequest['nama_kecamatan'],
                'id_kabupaten' => $Arryrequest['id_kabupaten'],
                'KodeDepdagri' => $Arryrequest['KodeDepdagri'],
                'IsActive' => $Arryrequest['IsActive'],
                /*'RegionalID' => $request->input('RegionalID'),
                'CreatedBy' => $request->input('CreatedBy'),
                'OriginalID' => $request->input('OriginalID'),
                'OriginalNama' => $request->input('OriginalNama'),
                'OriginalKode' => $request->input('OriginalKode'),
                'Created' => $request->input('Created'),
                'LastModified' => $request->input('LastModified'),
                'LastModifiedBy' => $request->input('LastModifiedBy'),
                'id_kabupaten_old' => $request->input('id_kabupaten_old'),
                'nama_kabupaten_old' => $request->input('nama_provinsi_old')*/
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
        $kab = Kecamatan::where('id_kecamatan', $id)->first();
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
            $id_kecamatan=$arrDataReq["id_kecamatan"];
            $KodeDepdagri=$arrDataReq["KodeDepdagri"];
            $IsActive=$arrDataReq["IsActive"];
            $id_kabupaten=$arrDataReq["id_kabupaten"];
        }else{

            $nama_kecamatan=$request->input["nama_kecamatan"];
            $id_kabupaten=$request->input["id_kabupaten"];
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
                $p->id_kabupaten = $id_kabupaten;
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
