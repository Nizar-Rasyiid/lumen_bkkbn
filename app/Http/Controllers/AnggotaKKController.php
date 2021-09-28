<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AnggotaKK;
use Illuminate\Support\Facades\DB;

class AnggotaKKController extends Controller {

    public function index()
    {
        return csrf_token(); 
    }

    public function getAnggotaKK()
    {
       $data = DB::table('anggota_kk_periode_sensus')
       ->get();


       if($data){
        $response = [
            'message'		=> 'Get Anggota KK',
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



    public function storeAnggotaKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
    
        $dataReq = $request->json()->all();
        $Arryrequest = json_decode(json_encode($dataReq), true);

    }else{
        $Arryrequest["KK_id"] =$request->$request->input("KK_id");
        $Arryrequest["periode_sensus"] =$request->$request->input("periode_sensus");
        $Arryrequest["NIK"] =$request->$request->input("NIK");
        $Arryrequest["jenis_kelamin"] =$request->$request->input("jenis_kelamin");
        $Arryrequest["tempat_lahir"] =$request->$request->input("tempat_lahir");
        $Arryrequest["tanggal_lahir"] =$request->$request->input("tanggal_lahir");
        $Arryrequest["agama"] =$request->$request->input("agama");
        $Arryrequest["pendidikan"] =$request->$request->input("pendidikan");
        $Arryrequest["jenis_pekerjaan"] =$request->$request->input("jenis_pekerjaan");
        $Arryrequest["status_nikah"] =$request->$request->input("status_nikah");
        $Arryrequest["tanggal_pernikahan"] =$request->$request->input("tanggal_pernikahan");
        $Arryrequest["status_dalam_keluarga"] =$request->$request->input("status_dalam_keluarga");
        $Arryrequest["kewarganegaraan"] =$request->$request->input("kewarganegaraan");
        $Arryrequest["no_paspor"] =$request->$request->input("no_paspor");
        $Arryrequest["no_katas"] =$request->$request->input("no_katas");
        $Arryrequest["nama_ayah"] =$request->$request->input("nama_ayah");
        $Arryrequest["nama_ibu"] =$request->$request->input("nama_ibu");
        $Arryrequest["create_by"] =$request->$request->input("create_by");
        $Arryrequest["update_by"] =$request->$request->input("update_by");
    }

    try {
        DB::beginTransaction();
        
        $p = new AnggotaKK([
            'KK_id' => $Arryrequest['KK_id'],
            'periode_sensus' => $Arryrequest['periode_sensus'],
            'NIK' => $Arryrequest['NIK'],
            'jenis_kelamin' => $Arryrequest['jenis_kelamin'],
            'tempat_lahir' => $Arryrequest['tempat_lahir'],
            'tanggal_lahir' => $Arryrequest['tanggal_lahir'],
            'agama' => $Arryrequest['agama'],
            'pendidikan' => $Arryrequest['pendidikan'],
            'jenis_pekerjaan' => $Arryrequest['jenis_pekerjaan'],
            'status_nikah' => $Arryrequest['status_nikah'],
            'tanggal_pernikahan' => $Arryrequest['tanggal_pernikahan'],
            'status_dalam_keluarga' => $Arryrequest['status_dalam_keluarga'],
            'kewarganegaraan' => $Arryrequest['kewarganegaraan'],
            'no_paspor' => $Arryrequest['no_paspor'],
            'no_katas' => $Arryrequest['no_katas'],
            'nama_ayah' => $Arryrequest['nama_ayah'],
            'nama_ibu' => $Arryrequest['nama_ibu'],
            'create_by' => $Arryrequest['create_by'],
            'update_by' => $Arryrequest['update_by'],
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

    public function getNIKAnggota()
    {
        $data = DB::select(DB::raw("SELECT NIK FROM anggota_kk_periode_sensus ORDER BY anggota_kk_id")
        );
       if($data){
        $response = [
            'message'		=> 'Get NIK Anggota',
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

    public function showAnggotaKK(Request $request)
    {
        
    if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $KK_id=$arrDataReq["KK_id"];
    }else{
        $KK_id=$request->input["KK_id"];
    }


    $data = DB::table('anggota_kk_periode_sensus')
    ->join('table_kk_periode_sensus','anggota_kk_periode_sensus.KK_id','=','table_kk_periode_sensus.KK_id')
    ->select('anggota_kk_periode_sensus.*','table_kk_periode_sensus.nama_kk')
    ->where('KK_id',$KK_id)
    ->get();
    



    if($data){
        $response = [
            'message'		=> 'Show Setting',
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


    public function updateAnggotaKK(Request $request)
    {

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $KK_id=$arrDataReq["KK_id"];
            $anggota_kk_id=$arrDataReq["    anggota_kk_id"];
            $periode_sensus=$arrDataReq["periode_sensus"];
            $NIK=$arrDataReq["NIK"];
            $jenis_kelamin=$arrDataReq["jenis_kelamin"];
            $tempat_lahir=$arrDataReq["tempat_lahir"];           
            $tanggal_lahir=$arrDataReq["tanggal_lahir"];
            $agama=$arrDataReq["agama"];
            $pendidikan=$arrDataReq["pendidikan"];
            $jenis_pekerjaan=$arrDataReq["jenis_pekerjaan"];
            $status_nikah=$arrDataReq["status_nikah"];
            $tanggal_pernikahan=$arrDataReq["tanggal_pernikahan"];
            $status_dalam_keluarga=$arrDataReq["status_dalam_keluarga"];
            $no_paspor=$arrDataReq["no_paspor"];
            $no_katas=$arrDataReq["no_katas"];
            $nama_ayah=$arrDataReq["nama_ayah"];
            $nama_ibu=$arrDataReq["nama_ibu"];
            $update_by=$arrDataReq["update_by"];
        }else{

            $KK_id=$request->input["KK_id"];
            $anggota_kk_id=$request->input["anggota_kk_id"];
            $periode_sensus=$request->input["periode_sensus"];
            $NIK=$request->input["NIK"];
            $jenis_kelamin=$request->input["jenis_kelamin"];
            $tempat_lahir=$request->input["tempat_lahir"];           
            $tanggal_lahir=$request->input["tanggal_lahir"];
            $agama=$request->input["agama"];
            $pendidikan=$request->input["pendidikan"];
            $jenis_pekerjaan=$request->input["jenis_pekerjaan"];
            $status_nikah=$request->input["status_nikah"];
            $tanggal_pernikahan=$request->input["tanggal_pernikahan"];
            $status_dalam_keluarga=$request->input["status_dalam_keluarga"];
            $no_paspor=$request->input["no_paspor"];
            $no_katas=$request->input["no_katas"];
            $nama_ayah=$request->input["nama_ayah"];
            $nama_ibu=$request->input["nama_ibu"];
            $update_by=$request->input["update_by"];
        }
        
  
        
        try {
            DB::beginTransaction();
      
            $p = AnggotaKK::find($anggota_kk_id);

                $p->KK_id = $KK_id;
                $p->periode_sensus = $periode_sensus;
                $p->NIK = $NIK;
                $p->jenis_kelamin = $jenis_kelamin;
                $p->tempat_lahir = $tempat_lahir;
                $p->tanggal_lahir = $tanggal_lahir;
                $p->agama = $agama;
                $p->pendidikan = $pendidikan;
                $p->jenis_pekerjaan = $jenis_pekerjaan;
                $p->status_nikah = $status_nikah;
                $p->tanggal_pernikahan = $tanggal_pernikahan;
                $p->status_dalam_keluarga = $status_dalam_keluarga;
                $p->no_paspor = $no_paspor;
                $p->no_katas = $no_katas;
                $p->nama_ayah = $nama_ayah;
                $p->nama_ibu = $nama_ibu;
                $p->update_by = $update_by;
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
                'message'        => 'Update Master anggota kk Suskses',
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