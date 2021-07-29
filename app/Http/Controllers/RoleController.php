<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role_list = Role::all();

        return view('role.index', compact('role_list'));
    }
}
