<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_list = User::all();

        return view('user.index', compact('user_list'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function profile($value='')
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('user.profile', compact('user'));
    }

    public function role(Request $request, $userId)
    {
        $user  = User::findOrFail($userId);
        $role = Role::all()->pluck('name');
        return view('user.role', compact('user', 'role'));
    }

    public function setRole(Request $request, $userId)
    {
        $this->validate($request, [
        'role' => 'required'
    ]);

        $user = User::findOrFail($userId);
        //menggunakan syncRoles agar terlebih dahulu menghapus semua role yang dimiliki
        //kemudian di-set kembali agar tidak terjadi duplicate
        $user->syncRoles($request->role);
        return redirect()->route('user.index')->with(['success' => 'Role Sudah Di Set']);
    }

    public function insertRoleByAdmin(Request $request)
    {
        $time = date('Y-m-d H:i:s');

        $this->validate($request, [
        'nama_lengkap' => 'required',
        'email' => 'required','email',
        'password' => 'required',
    ]);


        $user = User::create([
        'nama'     => $request['nama_lengkap'],
        'email'    => $request['email'],
        'password' => Hash::make($request['password']),
        'email_verified_at' => $time,
    ]);

        if ($request->typerole == 'admin') {
            $user->syncRoles('admin');
        } else {
            $user->syncRoles('evaluator');
        }

        return redirect('user');
    }
}
