<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Models\Unit;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

use Auth;

//use Helper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/perusahaan';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        //var_dump(servicePegawaiByNIP("199010302014022003"));
        //return view('beranda');

        return view('home_login');
    }
    public function showLoginSubmit(Request $request)
    {
        $request->validate([
            "nip" => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $peg_list=servicePegawaiByNIP($request->nip);
        //var_dump($peg_list);
        if (count($peg_list)!=0) {

        //echo $peg_list["nama"];//."nipnya = ".$peg_list->nip;
            $pass=$request->password;
            //echo "jumlah Record = ".$count;
            $passDb="";
            $usernameDb="";
            /* */
            Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_AutoLogin', "autologin", EW_COOKIE_EXPIRY_TIME())); // Set autologin cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_nip', $peg_list["nip"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_nama', $peg_list["nama"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_nama_full', $peg_list["nama_full"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_golongan', $peg_list["golongan"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_unit', $peg_list["unit"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
                 Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_1', $peg_list["es_1"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
        if ($peg_list["es_1"]) {
            Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_1', $peg_list["es_1"], EW_COOKIE_EXPIRY_TIME()));
            Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_1_id', $peg_list["es_1_id"], EW_COOKIE_EXPIRY_TIME()));
        } // Set user name cookie
            if ($peg_list["es_2"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_2', $peg_list["es_2"], EW_COOKIE_EXPIRY_TIME()));
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_2_id', $peg_list["es_2_id"], EW_COOKIE_EXPIRY_TIME()));
            } // Set user name cookie
            if ($peg_list["es_3"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_3_id', $peg_list["es_3_id"], EW_COOKIE_EXPIRY_TIME()));
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_3', $peg_list["es_3"], EW_COOKIE_EXPIRY_TIME()));
            } // Set user name cookie
            if ($peg_list["es_4"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_es_4', $peg_list["es_4"], EW_COOKIE_EXPIRY_TIME()));
            } // Set user name cookie
            if ($peg_list["leader"]["0"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_kode_org_1', $peg_list["leader"]["0"], EW_COOKIE_EXPIRY_TIME()));
            } // Set user name cookie
            if ($peg_list["leader"]["1"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_kode_org_2', $peg_list["leader"]["1"], EW_COOKIE_EXPIRY_TIME()));
            }
            if ($peg_list["leader"]["2"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_kode_org_3', $peg_list["leader"]["2"], EW_COOKIE_EXPIRY_TIME()));
            }
            if ($peg_list["leader"]["3"]) {
                Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_kode_org_4', $peg_list["leader"]["3"], EW_COOKIE_EXPIRY_TIME()));
            }


            //Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_leader', $peg_list["leader"], EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
        Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_status', "Pegawai", EW_COOKIE_EXPIRY_TIME())); // Set user name cookie
        Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_password', Encrypt_sppd($pass, $_ENV['EW_RANDOM_KEY']), EW_COOKIE_EXPIRY_TIME())); // Set password cookie
        Cookie::queue(Cookie::make($_ENV['EW_PROJECT_NAME'] . '_Checksum', crc32(md5($_ENV['EW_RANDOM_KEY'])), EW_COOKIE_EXPIRY_TIME()));
            return redirect('IndexUser');
        } else {
            return view('home_login');
        }
//        echo $peg_list["nama"];
        
        
        /**/
        //test();


        //var_dump($Unit_list);
        //echo "2323". $request->email;
        //return view('home_login');
    }
    public function username()
    {
        return 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            //'g-recaptcha-response' => 'required|captcha',
        ]);
    }
    /*
        public function authenticated()
        {
            if (Auth::user()->hasRole('admin')) {
                return redirect('user');
            } elseif (Auth::user()->hasRole('evaluator')) {
                return redirect('evaluator');
            }/
        }*/
}
