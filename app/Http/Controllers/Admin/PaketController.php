<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PaketController extends Controller
{

    public function index()
    {
        // dd(auth()->user());
        $active = 'penjualan';
        $data = Paket::all();
        return view('website.pages.paket', compact('active', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:pakets,name',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $data = new Paket();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Paket Berhasil ditambah', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pakets,id',
            'name' => 'required|unique:pakets,name',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = Paket::findOrFail($request->id);
        $data->fill($request->all());
        $data->save();

        Alert::toast('Paket Berhasil di update', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pakets,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = Paket::findOrFail($request->id);
        $data->delete();

        Alert::toast('Paket Berhasil dihapus', 'success');
        return back();
    }
}
