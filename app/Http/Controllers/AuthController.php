<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email:rfc,dns',
            'nip' => 'required|exists:users,nip',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return redirect()->route('login');
        }


        $data = [
            'nip' => $request->nip,
            'password' => $request->password
        ];


        if (!Auth::attempt($data)) {
            Alert::toast('Email or Password is wrong', 'error');
            return redirect()->route('login')->withInput();
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.sales.index');
        }

        return redirect()->route('pegawai.transaction.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
