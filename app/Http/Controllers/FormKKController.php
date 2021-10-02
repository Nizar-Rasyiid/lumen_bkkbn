<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FormKK;
use App\Models\AnggotaKK;
use App\Models\KB;

use Exception;
use Illuminate\Support\Facades\DB;

class FormKKController extends Controller {

    public function index()
    {
        return csrf_token(); 
    }

    public function getFormKK()
    {
        $data = DB::table('table_kk_periode_sensus')
        ->join('provinsi','table_kk_periode_sensus.id_provinsi' ,'=', 'provinsi.id_provinsi')
        ->join('kabupaten','table_kk_periode_sensus.id_kab' ,'=', 'kabupaten.id_kabupaten')
        ->join('kecamatan','table_kk_periode_sensus.id_kec' ,'=', 'kecamatan.id_kecamatan')
        ->join('kelurahan','table_kk_periode_sensus.id_kel' ,'=', 'kelurahan.id_kelurahan')
        ->join('rw','table_kk_periode_sensus.id_rw' ,'=', 'rw.id_rw')
        ->join('rt','table_kk_periode_sensus.id_rt' ,'=', 'rt.id_rt')
        ->select('table_kk_periode_sensus.*','nama_rt','nama_rw','nama_kelurahan','nama_kecamatan','nama_kabupaten','nama_provinsi')
        ->get();
        if($data){
            $response = [
                'message'		=> 'Get KK',
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
    public function getIdKK()
    {
        $data = DB::select(DB::raw("SELECT KK_id,NIK_KK FROM table_kk_periode_sensus ORDER BY KK_id DESC LIMIT 1"
    )
        );
       if($data){
        $response = [
            'message'		=> 'Get Id KK',
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

    public function showFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_provinsi = $arrDataReq["id_provinsi"];
            // $id_kab = $arrDataReq["id_kab"];
            // $id_kec = $arrDataReq["id_kec"];
            // $id_kel = $arrDataReq["id_kel"];
            // $id_rw =$arrDataReq["id_rw"];
            // $id_rt = $arrDataReq["id_rt"];

        }else{
            $id_provinsi = $request->input["id_provinsi"];
        }
        $data = DB::table('table_kk_periode_sensus')
        ->join('provinsi','table_kk_periode_sensus.id_provinsi','=','provinsi.id_provinsi')
        // ->join('kabupaten','table_kk_periode_sensus.id_kab' ,'=', 'kabupaten.id_kabupaten')
        // ->join('kecamatan','table_kk_periode_sensus.id_kec' ,'=', 'kecamatan.id_kec')
        // ->join('kelurahan','table_kk_periode_sensus.id_kel' ,'=', 'kelurahan.id_kel')
        // ->join('rw','table_kk_periode_sensus.id_rw' ,'=', 'rw.id_rw')
        // ->join('rt','table_kk_periode_sensus.id_rt' ,'=', 'rt.id_rt')
        ->select('table_kk_periode_sensus.*','provinsi.nama_provinsi')
        ->where(
        'table_kk_periode_sensus.id_provinsi', $id_provinsi,
        // 'table_kk_periode_sensus.id_kab', $id_kab,
        // 'table_kk_periode_sensus.id_kec', $id_kec,
        // 'table_kk_periode_sensus.id_kel', $id_kel,
        // 'table_kk_periode_sensus.id_rw', $id_rw,
        // 'table_kk_periode_sensus.id_rt', $id_rt,
        )
        ->get();
    
                try {
        if($data){
                $response = [
                    'message'		=> 'Update Form KK Sukses',
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
    public function storeFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["NoKK"] =$request->$request->input("NoKK");
            $Arryrequest["NIK_KK"] =$request->$request->input("NIK_KK");
            $Arryrequest["nama_kk"] =$request->$request->input("nama_kk");
            $Arryrequest["alamat_kk"] =$request->$request->input("alamat_kk");
            $Arryrequest["id_provinsi"] =$request->$request->input("id_provinsi");
            $Arryrequest["id_kab"] =$request->$request->input("id_kab");
            $Arryrequest["id_kec"] =$request->$request->input("id_kec");
            $Arryrequest["id_kel"] =$request->$request->input("id_kel");
            $Arryrequest["id_rw"] =$request->$request->input("id_rw");
            $Arryrequest["id_rt"] =$request->$request->input("id_rt");
            $Arryrequest["create_by"] =$request->$request->input("create_by");
            $Arryrequest["update_by"] =$request->$request->input("update_by");
        }

        try {
            DB::beginTransaction();

            $p = new FormKK([
                'periode_sensus' => $Arryrequest['periode_sensus'],
                'NoKK' => $Arryrequest['NoKK'],
                'NIK_KK' => $Arryrequest['NIK_KK'],
                'nama_kk' => $Arryrequest['nama_kk'],
                'alamat_kk' => $Arryrequest['alamat_kk'],
                'id_provinsi' => $Arryrequest['id_provinsi'],
                'id_kab' => $Arryrequest['id_kab'],
                'id_kec' => $Arryrequest['id_kec'],
                'id_kel' => $Arryrequest['id_kel'],
                'id_rw' => $Arryrequest['id_rw'],
                'id_rt' => $Arryrequest['id_rt'],
                'create_by' => $Arryrequest['create_by'],
                'update_by' => $Arryrequest['update_by'],
            ]);

            $p->save();

            DB::commit();
        
            $response = [
                'message'        => 'Input Data Sukses',
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

    public function acceptFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["KK"] =$request->$request->input("KK");
        }

        try {
            // var_dump($Arryrequest["KK"]);
            $dataKK = $Arryrequest["KK"];
            // echo($dataKK.length);
            // var_dump($dataKK);
            // die();
            for ($i=0; $i < count($dataKK) ; $i++) { 
                $dataAnggota = $dataKK[$i]['AnggotaKK'];
                $dataKB = $dataKK[$i]['kb'];
                // var_dump($dataKB);
                // die();
                DB::beginTransaction();
                $p = new FormKK([
                    // 'KK' => $dataKK,
                    'periode_sensus' => $dataKK[$i]['periode_sensus'],
                    'NoKK' => $dataKK[$i]['NoKK'],
                    'NIK_KK' => $dataKK[$i]['NIK_KK'],
                    'nama_kk' => $dataKK[$i]['nama_kk'],
                    'alamat_kk' => $dataKK[$i]['alamat_kk'],
                    'id_provinsi' => $dataKK[$i]['id_provinsi'],
                    'id_kab' => $dataKK[$i]['id_kabupaten'],
                    'id_kec' => $dataKK[$i]['id_kecamatan'],
                    'id_kel' => $dataKK[$i]['id_kelurahan'],
                    'id_rw' => $dataKK[$i]['id_rw'],
                    'id_rt' => $dataKK[$i]['id_rt'],
                    'create_by' => $dataKK[$i]['create_by'],
                    'update_by' => $dataKK[$i]['update_by'],
                ]);
                
                $p->save();
                // echo(dataKK[i]['NoKK']);
                
                DB::commit();
                $create_by = $dataKK[0]['create_by'];
                // echo($create_by);
                $dataKKID = DB::select(DB::raw("SELECT KK_id FROM table_kk_periode_sensus WHERE  create_by ='".$create_by."' ORDER BY KK_id desc LIMIT 0,1"));
                // var_dump($dataKKID[0]->KK_id);
                $KK_id = $dataKKID[0]->KK_id;

                // anggotakk
                for ($i=0; $i < count($dataAnggota) ; $i++) { 
                    DB::beginTransaction();
                    $p = new AnggotaKK([
                        // 'KK' => $dataKK,
                        'KK_id' => $KK_id,
                        'periode_sensus' => $dataAnggota[$i]['periode_sensus'],
                        'nama_anggota' => $dataAnggota[$i]['nama_anggota'],
                        'NIK' => $dataAnggota[$i]['NIK'],
                        'jenis_kelamin' => $dataAnggota[$i]['jenis_kelamin'],
                        'tempat_lahir' => $dataAnggota[$i]['tempat_lahir'],
                        'tanggal_lahir' => $dataAnggota[$i]['tanggal_lahir'],
                        'agama' => $dataAnggota[$i]['agama'],
                        'pendidikan' => $dataAnggota[$i]['pendidikan'],
                        'jenis_pekerjaan' => $dataAnggota[$i]['jenis_pekerjaan'],
                        'status_nikah' => $dataAnggota[$i]['status_nikah'],
                        'tanggal_pernikahan' => $dataAnggota[$i]['tanggal_pernikahan'],
                        'status_dalam_keluarga' => $dataAnggota[$i]['status_dalam_keluarga'],
                        'kewarganegaraan' => $dataAnggota[$i]['kewarganegaraan'],
                        'no_paspor' => $dataAnggota[$i]['no_paspor'],
                        'no_katas' => $dataAnggota[$i]['no_katas'],
                        'nama_ayah' => $dataAnggota[$i]['nama_ayah'],
                        'nama_ibu' => $dataAnggota[$i]['nama_ibu'],
                        'create_by' => $dataAnggota[$i]['create_by'],
                        'update_by' => $dataAnggota[$i]['update_by'],
                    ]);
                    
                    $p->save();
                    // echo(dataKK[i]['NoKK']);
                    
                    DB::commit();

                }
                
                    // kb
                for ($i=0; $i < count($dataKB) ; $i++) { 
                    DB::beginTransaction();
                    $p = new KB([
                        // 'KK' => $dataKK,
                        'KK_id' => $KK_id,
                        'NIK' => $dataKB[$i]['NIK'],
                        // 'nama_anggota' => $dataKB[$i]['nama_anggota'],
                        // 'anggota_kk_id' => $dataKB[$i]['anggota_kk_id'],
                        'alat_kontrasepsi' => $dataKB[$i]['alat_kontrasepsi'],
                        'tahun_pemakaian' => $dataKB[$i]['tahun_pemakaian'],
                        'alasan' => $dataKB[$i]['alasan'],
                        'CreatedBy' => $dataKB[$i]['CreatedBy'],
                        'LastModifiedBy' => $dataKB[$i]['LastModifiedBy'],
                    ]);
                    
                    $p->save();
                    // echo(dataKK[i]['NoKK']);
                    
                    DB::commit();
                    // var_dump($dataKK[$i]['kb']);
                }
            }

            //AnggotaKK
            

            //KB
            


            // DB::beginTransaction();
            // $p = new FormKK([
              
            //     'periode_sensus' => $Arryrequest['periode_sensus'],
            //     'NoKK' => $Arryrequest['NoKK'],
            //     'NIK_KK' => $Arryrequest['NIK_KK'],
            //     'nama_kk' => $Arryrequest['nama_kk'],
            //     'alamat_kk' => $Arryrequest['alamat_kk'],
            //     'id_provinsi' => $Arryrequest['id_provinsi'],
            //     'id_kab' => $Arryrequest['id_kab'],
            //     'id_kec' => $Arryrequest['id_kec'],
            //     'id_kel' => $Arryrequest['id_kel'],
            //     'id_rw' => $Arryrequest['id_rw'],
            //     'id_rt' => $Arryrequest['id_rt'],
            //     'create_by' => $Arryrequest['create_by'],
            //     'update_by' => $Arryrequest['update_by'],
            // ]);

           
        
            $response = [
                'message'        => 'Input Data Sukses',
                // 'dataKKID'       => $dataKKID
            ];

            return response()->json($response, 201);
        }
         catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function updateFormKK(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $KK_id=$arrDataReq["KK_id"];
            $periode_sensus=$arrDataReq["periode_sensus"];
            $NoKK=$arrDataReq["NoKK"];
            $NIK_KK=$arrDataReq["NIK_KK"];
            $nama_kk=$arrDataReq["nama_kk"];
            $alamat_kk=$arrDataReq["NoKK"];
            $id_provinsi=$arrDataReq["id_provinsi"];
            $id_kab=$arrDataReq["id_kab"];
            $id_kec=$arrDataReq["id_kec"];
            $id_kel=$arrDataReq["id_kel"];
            $id_rw=$arrDataReq["id_rw"];
            $id_rt=$arrDataReq["id_rt"];
            $update_by=$arrDataReq["update_by"];
        }else{
            $KK_id=$request->input["KK_id"];
            $NoKK=$request->input["NoKK"];
            $NIK_KK=$arrDataReq["NIK_KK"];
            $nama_kk=$arrDataReq["nama_kk"];
            $alamat_kk=$arrDataReq["NoKK"];
            $id_provinsi=$request->input["id_provinsi"];
            $id_kab=$request->input["id_kab"];
            $id_kec=$request->input["id_kec"];
            $id_kel=$request->input["id_kel"];
            $id_rw=$request->input["id_rw"];
            $id_rt=$request->input["id_rt"];
            $periode_sensus=$arrDataReq["periode_sensus"];
            $update_by=$request->input["update_by"];
        }
        

        
        try {
            DB::beginTransaction();
    
            $p = FormKK::find($KK_id);

                $p->periode_sensus = $periode_sensus;
                $p->NoKK = $NoKK;
                $p->NIK_KK = $NIK_KK;
                $p->nama_kk = $nama_kk;
                $p->alamat_kk = $alamat_kk;
                $p->id_provinsi = $id_provinsi;
                $p->id_kab = $id_kab;
                $p->id_kec = $id_kec;
                $p->id_kel = $id_kel;
                $p->id_rw = $id_rw;
                $p->id_rt = $id_rt;
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
                'message'        => 'Update Form KK Suskses',
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

    public function deleteFormKK(Request $request)
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

        $data = FormKK::find($KK_id);
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
    public function showKKPerProv(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $Periode_Sensus = $arrDataReq["Periode_Sensus"];
        }else{
            $Periode_Sensus = $request->input["Periode_Sensus"];
        }

        $data = DB::select(DB::raw("SELECT 
        provinsi.id_provinsi,   
        provinsi.nama_provinsi,   
        target_sensus_indo.Periode_Sensus
        FROM (SELECT 
        id_provinsi, 
        Periode_Sensus
        FROM table_kk_periode_sensus 
        GROUP BY id_provinsi, Periode_Sensus HAVING Periode_Sensus = $Periode_Sensus ) target_sensus_indo 
        INNER JOIN provinsi ON target_sensus_indo.id_provinsi = provinsi.id_provinsi
        "
        )
        );


        
        try {
           if($data){
                $response = [
                    'message'		=> 'Show TargetKk per provinsi Sukses',
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