<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\WebSetting;
//use App\Models\Provinsi;
use App\Models\V_user;
use DB;

class VuserController extends Controller
{

/*
    public function viewuser()
    {
        V_user = V_user::all();

        return view('datamaster.user', compact('V_user'));
    }
*/


    public function getUser()
    {
        $data = V_user::all();

        if($data){
            $response = [
                'message'		=> 'Show User',
                'code'          => '00',
                'data' 		    => $data,
            ];

            return response()->json($response, 200);
        }

        $response = [
            'message'		=> 'An Error Occured',
            'code'          => '02'
        ];

        return response()->json($response, 500);

    }

    //provisi ################################################
public function index()
{
    return csrf_token(); 
}
    public function showUser(Request $request)
    {
        
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $UserName=$arrDataReq["UserName"];
            $password=$arrDataReq["password"];
        }else{
            $UserName=$request->input('UserName');
            $password=$request->input('password');
        }
        $data = new V_user();
        $data =  $data->select('id','UserName','NamaLengkap',
        'NIP','NIK','KabupatenKotaID','RoleID','Jabatan','Foto')
                ->where(['UserName'=>$UserName,/*$request->input('UserName'),*/
            'Password'=>md5($password)])->get();
            
        
        try {
           if(count($data)==1){
                $response = [
                    'message'		=> 'Show User',
                    'code'          => '00',
                    'data' 		    => $data,
                ];

                return response()->json($response, 200);
            }else{
                $response = [
                    'message'		=> 'Login tidak sesuai',
                    'code'          => '01',
                    'data' 		    => $data,
                ];

            }

                return response()->json($response, 200);


        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'code'          => '02',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
                


    }

    public function storeUser(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);

        }else{
            $Arryrequest["UserName"] =$request->$request->input("UserName");
            $Arryrequest["NamaLengkap"] =$request->$request->input("NamaLengkap");
            $Arryrequest["Jabatan"] =$request->$request->input("Jabatan");
            $Arryrequest["Password"] =$request->$request->input("Password");
        }
        // echo json_encode($Arryrequest);
        //console.log($Arryrequest)
        /*        $this->validate($Arryrequest, [

            'UserName'   => 'required',
            'Jabatan'   => 'required',
            'Password'   => 'required',
        ]);*/

        try {
            DB::beginTransaction();
            
            $p = new V_user([
                'UserName' => $Arryrequest['UserName'],
                'NamaLengkap' => $Arryrequest['NamaLengkap'],
                'Jabatan' => $Arryrequest['Jabatan'],
                'Password' => md5($Arryrequest['Password']),
                /*'RegionalID' => $request->input('RegionalID'),
                'OriginalID' => $request->input('OriginalID'),
                'OriginalNama' => $request->input('OriginalNama'),
                'OriginalKode' => $request->input('OriginalKode'),
                'Created' => $request->input('Created'),
                'CreatedBy' => $request->input('CreatedBy'),
                'LastModified' => $request->input('LastModified'),
                'LastModifiedBy' => $request->input('LastModifiedBy'),
                'id_kabupaten_old' => $request->input('id_kabupaten_old'),
                'UserName_old' => $request->input('UserName_old')*/
            ]);

            $p->save();

            DB::commit();
            
            $response = [
                'message'        => 'Success',
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

    public function updateUser(Request $request)
    {

        //
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $UserName=$arrDataReq["UserName"];
            $NamaLengkap=$arrDataReq["NamaLengkap"];
            $Jabatan=$arrDataReq["Jabatan"];
            $Password=$arrDataReq["Password"];
            $id=$arrDataReq["id"];
        }else{

            $UserName=$request->input["UserName"];
            $NamaLengkap=$request->input["NamaLengkap"];
            $Jabatan=$request->input["Jabatan"];
            $Password=$request->input["Password"];
            $id=$request->input["id"];
        }
        
        /*
              $this->validate($request, [
            
                  'UserName'   => 'required',
                  'NamaLengkap'   => 'required',
                  'Jabatan'   => 'required',
              ]);
        */
        
        try {
            DB::beginTransaction();
      
            $p = V_user::find($id);

                $p->UserName = $UserName;
                $p->NamaLengkap = $NamaLengkap;
                $p->Jabatan = $Jabatan;
                $p->Password = md5($Password);
                /*$p->RegionalID = $request->input('RegionalID');
                $p->OriginalID = $request->input('OriginalID');
                $p->OriginalNama = $request->input('OriginalNama');
                $p->OriginalKode = $request->input('OriginalKode');
                $p->Created = $request->input('Created');
                $p->CreatedBy = $request->input('CreatedBy');
                $p->LastModified = $request->input('LastModified');
                $p->LastModifiedBy = $request->input('LastModifiedBy');
                $p->id_old = $request->input('id_old');
                $p->UserName_old = $request->input('UserName_old');*/


            
            $p->save();
            DB::commit();

            $response = [
                'message'        => 'Update Master User Suskses',
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

        $response = [
            'message'        => 'An Error Occured'
        ];

        return response()->json($response, 200);
    }

    public function deleteUser(Request $request)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
        && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            //json_decode($dataReq, true);
            $arrDataReq =json_decode(json_encode($dataReq),true);
            $id=$arrDataReq["id"];
        }else{
            $id=$request->input["id"];
        }

        $data = V_user::find($id);
        try {
            if($data->delete()){
                 $response = [
                     'message'		=> 'Delete V_user Sukses',
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