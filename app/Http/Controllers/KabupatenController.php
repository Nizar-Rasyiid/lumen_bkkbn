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


    public function laporanKab()
    {
        $data = DB::select(DB::raw("SELECT Nama_Kabupaten,
COUNT(DISTINCT(kec.`id_kecamatan`)) AS Jumlah_Kecamatan,
COUNT(DISTINCT(kel.`id_kelurahan`)) AS Jumlah_Kelurahan,
COUNT(DISTINCT(rw.`id_rw`)) AS Jumlah_RW, 
COUNT(DISTINCT(rt.`id_rt`)) AS Jumlah_RT
FROM Kabupaten Kab 
LEFT JOIN  Kecamatan kec ON kec.`id_kabupaten`=kab.`id_kabupaten`
LEFT JOIN Kelurahan kel ON kel.`id_kecamatan`= kec.`id_kecamatan`
LEFT JOIN RW rw ON rw.`id_kelurahan`=kel.`id_kelurahan`
LEFT JOIN RT rt ON rt.`id_rw`=rw.`id_rw` 
GROUP BY Kab.`id_kabupaten`,kab.`nama_kabupaten`"
        )
    );



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






    public function getKab()
    {
        $data = DB::table('kabupaten')
                ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
                ->select('kabupaten.*','provinsi.nama_provinsi')
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
    public function showKabs(Request $request)
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

        $data = DB::select(DB::raw("SELECT Nama_Kabupaten,
        COUNT(DISTINCT(kab.`id_kabupaten`)) AS Jumlah_Kabupaten_Kota, 
        COUNT(DISTINCT(kec.`id_kecamatan`)) AS Jumlah_Kecamatan,
        COUNT(DISTINCT(kel.`id_kelurahan`)) AS Jumlah_Kelurahan,
        COUNT(DISTINCT(rw.`id_rw`)) AS Jumlah_RW, 
        COUNT(DISTINCT(rt.`id_rt`)) AS Jumlah_RT
        FROM Provinsi Prov 
        LEFT JOIN Kabupaten Kab ON kab.`id_provinsi`= Prov.`id_provinsi`
        LEFT JOIN  Kecamatan kec ON kec.`id_kabupaten`=kab.`id_kabupaten`
        LEFT JOIN Kelurahan kel ON kel.`id_kecamatan`= kec.`id_kecamatan`
        LEFT JOIN RW rw ON rw.`id_kelurahan`=kel.`id_kelurahan`
        LEFT JOIN RT rt ON rt.`id_rw`=rw.`id_rw` 
        GROUP BY Prov.`id_provinsi`,Kab.`nama_kabupaten`
        HAVING Prov.`id_provinsi`=$id_provinsi"								
        )
        );

        if($data){
            $response = [
                'message'		=> 'Show Provinsi',
                'data' 		    => $data,
            ];

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
            $id_provinsi = $arrDataReq["id_provinsi"];
        }else{
            $id_provinsi = $request->input["id_provinsi"];
        }
        $data = DB::table('kabupaten')
        ->join('provinsi','kabupaten.id_provinsi','=','provinsi.id_provinsi')
        ->select('kabupaten.*','provinsi.nama_provinsi')
        ->where('kabupaten.id_provinsi', $id_provinsi)
        ->get();
    
                try {
        if($data){
                $response = [
                    'message'		=> 'Update Kabupaten Sukses',
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

    public function showPerKab(Request $request)
    {if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $id_kabupaten = $arrDataReq["id_kabupaten"];
    }else{
        $id_kabupaten = $request->input["id_kabupaten"];
    }

        $data = DB::select(DB::raw("SELECT Nama_Kabupaten,
        COUNT(DISTINCT(kec.`id_kecamatan`)) AS Jumlah_Kecamatan,
        COUNT(DISTINCT(kel.`id_kelurahan`)) AS Jumlah_Kelurahan,
        COUNT(DISTINCT(rw.`id_rw`)) AS Jumlah_RW, 
        COUNT(DISTINCT(rt.`id_rt`)) AS Jumlah_RT
        FROM Kabupaten Kab 
        LEFT JOIN  Kecamatan kec ON kec.`id_kabupaten`=kab.`id_kabupaten`
        LEFT JOIN Kelurahan kel ON kel.`id_kecamatan`= kec.`id_kecamatan`
        LEFT JOIN RW rw ON rw.`id_kelurahan`=kel.`id_kelurahan`
        LEFT JOIN RT rt ON rt.`id_rw`=rw.`id_rw` 
        GROUP BY Kab.`id_kabupaten`,kab.`nama_kabupaten`
        HAVING Kab.`id_kabupaten` = $id_kabupaten
        "
                )
            );

            try {
                if($data){
                     $response = [
                         'message'		=> 'Update Per Kabupaten Sukses',
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
            $Arryrequest["CreatedBy"] =$request->$request->input("CreatedBy");
            $Arryrequest["LastModifiedBy"] =$request->$request->input("LastModifiedBy");
        }
        // echo json_encode($Arryrequest);
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
                'CreatedBy' => $Arryrequest['CreatedBy'],
                'LastModifiedBy' => $Arryrequest['LastModifiedBy'],
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
    
    public function deleteKab(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id_kabupaten=$arrDataReq["id_kabupaten"];
        }else{
            $id_kabupaten=$request->input["id_kabupaten"];
        }

        $data = Kabupaten::find($id_kabupaten);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete Kabupaten Sukses',
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
        $LastModifiedBy=$arrDataReq["LastModifiedBy"];
    }else{

        $nama_kabupaten=$request->input["nama_kabupaten"];
        $id_provinsi=$request->input["id_provinsi"];
        $KodeDepdagri=$request->input["KodeDepdagri"];
        $IsActive=$request->input["IsActive"];
        $id_kabupaten=$request->input["id_kabupaten"];
        $LastModifiedBy=$request->input["LastModifiedBy"];
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
