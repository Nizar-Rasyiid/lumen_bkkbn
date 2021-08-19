<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
//use App\Models\Provinsi;
use App\Models\Provinsi;
//use App\Models\V_user;
//use DB;
use Exception;

use Illuminate\Support\Facades\DB;


class ProvinsiController extends Controller
{



    //provisi ################################################

public function index()
{
    return csrf_token(); 
}

public function laporanProv()
{
    $data = DB::select(DB::raw("SELECT Nama_Provinsi,
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
    GROUP BY Prov.`id_provinsi`,prov.`nama_provinsi`")								
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

public function laporanPerProv(Request $request)
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

    $data = DB::select(DB::raw("SELECT
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
    GROUP BY Prov.`id_provinsi`
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


    public function getProv()
    {
        $data = Provinsi::all();

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

    public function showProv($id)
    {
        $data = new Provinsi();
        $data =  $data->select('id_provinsi','nama_provinsi','KodeDepdagri',
        'IsActive','RegionalID','OriginalID','OriginalNama','OriginalKode','Created',
        'CreatedBy','LastModifiedBy','id_provinsi_old','nama_provinsi_old')
                ->find($id);
        
        try {
           if($data){
                $response = [
                    'message'		=> 'Udapte Provinsi Sukses',
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
public function storeProv(Request $request)
{
     if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        $Arryrequest = json_decode(json_encode($dataReq), true);

    }else{
        $Arryrequest["nama_provinsi"] =$request->$request->input("nama_provinsi");
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
        
        $p = new Provinsi([
            'nama_provinsi' => $Arryrequest['nama_provinsi'],
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

    public function deleteProv(Request $request)
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

        $data = Provinsi::find($id_provinsi);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete Provinsi Sukses',
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
public function updateProv(Request $request)
{

    //
    if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
    ) {
        $dataReq = $request->json()->all();
        //json_decode($dataReq, true);
        $arrDataReq =json_decode(json_encode($dataReq),true);
        $nama_provinsi=$arrDataReq["nama_provinsi"];
        $KodeDepdagri=$arrDataReq["KodeDepdagri"];
        $IsActive=$arrDataReq["IsActive"];
        $id_provinsi=$arrDataReq["id_provinsi"];
        $LastModifiedBy=$arrDataReq["LastModifiedBy"];
    }else{

        $nama_provinsi=$request->input["nama_provinsi"];
        $KodeDepdagri=$request->input["KodeDepdagri"];
        $IsActive=$request->input["IsActive"];
        $id_provinsi=$request->input["id_provinsi"];
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
  
        $p = Provinsi::find($id_provinsi);

            $p->nama_provinsi = $nama_provinsi;
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
            'message'        => 'Update Master Provinsi Suskses',
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