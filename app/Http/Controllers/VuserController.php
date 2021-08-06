<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
//use App\Models\WebSetting;
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



}