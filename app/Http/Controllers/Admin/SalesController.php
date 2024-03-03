<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SalesController extends Controller
{
    public function index()
    {
        $active = 'sales';
        $nip = User::generateNIP();
        $data = User::where('role', '!=', 'admin')->get();

        return view('website.pages.pegawai', compact('active', 'nip', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:users,nip',
            'name' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = new User();
        $data->fill($request->all());
        $data->password = Hash::make($request->password);
        $data->save();

        Alert::toast('User Berhasil ditambah', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'nip' => 'required',
            'name' => 'required',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = User::find($request->id);
        $data->nip = $request->nip;
        $data->name = $request->name;
        if ($request->has($request->password)) {
            $data->password = Hash::make($request->password);
        }

        $data->save();

        Alert::toast('User berhasil di update', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        User::where('id', $request->id)->delete();

        Alert::toast('User berhasil dihapus', 'success');
        return back();
    }
}
