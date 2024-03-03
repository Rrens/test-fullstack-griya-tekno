<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Paket;
use App\Models\PhotoHouseCustomer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index()
    {
        // return 'oke';
        $active = 'transaction-pegawai';
        $transaction = Transaction::with('customer', 'paket')->where('user_id', Auth::user()->id)->get();
        // dd($transaction);
        $paket = Paket::all();
        $customer = Customer::all();
        $house_customer = PhotoHouseCustomer::all();
        return view('website.pages.transaction-pegawai', compact(
            'active',
            'customer',
            'paket',
            'transaction',
            'house_customer'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'paket' => 'required|exists:pakets,id',
            'photo_ktp' => 'required|image|mimes:jpeg,png,jpg,JPG',
            'photo_house.*' => 'required|image|mimes:jpeg,png,jpg,JPG',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone_number = $request->phone;
        $customer->address = $request->address;
        $ktp = $request->file('photo_ktp');
        $image_ktp = bin2hex(time() . '' . $ktp->getClientOriginalName()) . '.' . $ktp->getClientOriginalExtension();
        Storage::putFileAs('public/uploads/images/ktp/', $ktp, $image_ktp);
        $customer->photo_ktp = $image_ktp;
        $customer->save();

        $count = count($request->photo_house);

        for ($i = 0; $i < $count; $i++) {
            $photo_house = new PhotoHouseCustomer();
            $photo_house->customer_id = $customer->id;
            $house = $request->file('photo_house')[$i];
            $image_house = bin2hex(time() . $i . $house->getClientOriginalName()) . '.' . $house->getClientOriginalExtension();
            Storage::putFileAs('public/uploads/images/house/', $house, $image_house);
            $photo_house->photo_house = $image_house;
            $photo_house->save();
        }

        $transaction = new Transaction();
        $transaction->customer_id = $customer->id;
        $transaction->paket_id = $request->paket;
        $transaction->user_id = Auth::user()->id;
        $transaction->save();

        Alert::toast('Transaksi Sukses', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'id' => 'required|exists:transactions,id',
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'paket' => 'required|exists:pakets,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        Transaction::where('id', $request->id)->update(['paket_id' => $request->paket]);

        $data = Customer::findOrFail($request->id);
        $data->name = $request->name;
        $data->phone_number = $request->phone_number;
        $data->address = $request->address;
        $data->save();

        Alert::toast('Data Berhasil di update', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:transactions,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $transaction = Transaction::findOrFail($request->id);
        $customer = Customer::where('id', $transaction->customer_id)->first();
        Storage::delete('public/uploads/images/house/' . '/' . $customer->photo_ktp);

        $photo_house = PhotoHouseCustomer::where('id', $customer->id)->get();
        $count = count($photo_house);
        for ($i = 0; $i < $count; $i++) {
            Storage::delete('public/uploads/images/house/' . '/' . $photo_house[$i]->photo_house);
            $photo_house[$i]->delete();
        }
        $customer->delete();
        $transaction->delete();

        Alert::toast('Transaksi Berhasil dihapus', 'success');
        return back();
    }

    public function update_ktp_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:customers,id',
            'photo_ktp' => 'required|image|mimes:jpeg,png,jpg,JPG',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = Customer::findOrFail($request->id);
        Storage::delete('public/uploads/images/ktp/' . '/' . $data->photo_ktp);
        $ktp = $request->file('photo_ktp');
        $image_ktp = bin2hex(time() . '' . $ktp->getClientOriginalName()) . '.' . $ktp->getClientOriginalExtension();
        Storage::putFileAs('public/uploads/images/ktp/', $ktp, $image_ktp);
        $data->photo_ktp = $image_ktp;
        $data->save();

        Alert::toast('Foto KTP Berhasil diubah', 'success');
        return back();
    }

    public function update_house_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:photo_house_customers,id',
            'photo_house' => 'required|image|mimes:jpeg,png,jpg,JPG',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = PhotoHouseCustomer::findOrFail($request->id);
        Storage::delete('public/uploads/images/house/' . '/' . $data->photo_house);
        $house = $request->file('photo_house');
        $image_house = bin2hex(time() . '' . $house->getClientOriginalName()) . '.' . $house->getClientOriginalExtension();
        Storage::putFileAs('public/uploads/images/house/', $house, $image_house);
        $data->photo_house = $image_house;
        $data->save();

        Alert::toast('Foto Rumah Berhasil di update', 'success');
        return back();
    }

    public function delete_house_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:photo_house_customers,id',
            'customer_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $check = PhotoHouseCustomer::where('customer_id', $request->customer_id)->count();

        if ($check < 2) {
            Alert::toast('Foto Rumah Minimal ada 1', 'error');
            return back();
        }

        $data = PhotoHouseCustomer::findOrFail($request->id);
        Storage::delete('public/uploads/images/house/' . '/' . $data->photo_house);
        $data->delete();

        Alert::toast('Foto Rumah Berhasil di hapus', 'success');
        return back();
    }
}
