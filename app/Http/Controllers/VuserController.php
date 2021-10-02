<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
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
    'Alamat','NIP','NIK','KabupatenKotaID','RoleID','Jabatan','Email')
            ->where(['UserName'=>$UserName,/*$request->input('UserName'),*/
        'Password'=>md5($password)])->get();
        
        
    $data2 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 2"));
    $data3 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 8"));
    $data4 = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 9"));
    $alatKB = DB::select(DB::raw("SELECT * FROM setting WHERE Id_kelompok_data = 14"));

    
    try {
       if(count($data)==1){
           
            $response = [
                'message'		=> 'Show User',
                'code'          => '00',
                'data' 		    => $data,
                'data2'         =>$data2,
                'data3'         =>$data3,
                'data4'         =>$data4,
                'alatKB'        =>$alatKB
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
            $Arryrequest["Email"] =$request->$request->input("Email");
            // $Arryrequest["Foto"] =$request->$request->input("Foto");
            $Arryrequest["NIK"] =$request->$request->input("NIK");
            $Arryrequest["Alamat"] =$request->$request->input("Alamat");
            $Arryrequest["Password"] =$request->$request->input("Password");
            $Arryrequest["Title Email"] =$request->$request->input("Title Email");
            $Arryrequest["body"] =$request->$request->input("body");
            $Arryrequest["url"] =$request->$request->input("url");
        }
        // echo json_encode($Arryrequest);
        //console.log($Arryrequest)s
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
                'Email' => $Arryrequest['Email'],
                // 'Foto' => $Arryrequest['Foto'],
                'NIK' => $Arryrequest['NIK'],
                'Alamat' => $Arryrequest['Alamat'],
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
            
            // $data = [$p];
            // Mail::send('mail', $data, function($message) {
            //     var_dump($message);
            //     $message->to('santriquarta@gmail.com', 'Dzul')->subject('Test Mail from lumen');
            //     $message->from('dzulkurrr@gmail.com','Admin');
            // });
            $body = str_replace('[UserName]',$Arryrequest['UserName'],$Arryrequest['body']);
            $body = str_replace('[Password]',$Arryrequest['Password'],$body);
            $body = str_replace('[url]',$Arryrequest['url'],$body);
            $details = [
                'title' => $Arryrequest['Title Email'],
                'body' => $body,
                ];
               
                Mail::to($Arryrequest['Email'])->send(new \App\Mail\MyTestMail($details));

            $response = [
                'message'        => 'Success. Email Sent, Check your inbox',
                'data'         => $p
            ];
            
            // echo 'Email Sent. Check your inbox.';

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

    public function ubahPassword(Request $request)
    {
         //
         if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
         && $request->isJson()
     ) {
         $dataReq = $request->json()->all();
         //json_decode($dataReq, true);
         $arrDataReq =json_decode(json_encode($dataReq),true);
         $Password=$arrDataReq["Password"];
         $NamaLengkap = $arrDataReq["NamaLengkap"];
         $Alamat=$arrDataReq["Alamat"];
         $id=$arrDataReq["id"];
     }else{

         $Password=$request->input["Password"];
         $NamaLengkap=$request->input["NamaLengkap"];
         $Alamat=$request->input["Alamat"];
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

            $p->NamaLengkap=$NamaLengkap;
            $p->Alamat=$Alamat;
             $p->Password = md5($Password);
   


         
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
            $Email=$arrDataReq["Email"];
            $NIK=$arrDataReq["NIK"];
            $Alamat=$arrDataReq["Alamat"];
            $Password=$arrDataReq["Password"];
            $id=$arrDataReq["id"];
        }else{

            $UserName=$request->input["UserName"];
            $NamaLengkap=$request->input["NamaLengkap"];
            $Jabatan=$request->input["Jabatan"];
            $Email=$request->input["Email"];
            $NIK=$request->input["NIK"];
            $Alamat=$request->input["Alamat"];
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
                $p->NIK = $NIK;
                $p->Alamat = $Alamat;
                $p->NamaLengkap = $NamaLengkap;
                $p->Email = $Email;
                $p->Jabatan = $Jabatan;
                $p->Password = $Password;

            
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