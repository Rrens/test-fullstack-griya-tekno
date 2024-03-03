<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PhotoHouseCustomer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index()
    {
        $active = 'transaction';
        $data = Transaction::with('customer', 'paket', 'user')->get();
        $customer = Customer::all();
        $user = User::all();
        $house_customer = PhotoHouseCustomer::all();
        // dd($data);
        return view('website.pages.transaction', compact('active', 'customer', 'user', 'data', 'house_customer'));
    }

    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:transactions,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        $data = Transaction::findOrFail($request->id);
        if ($data->is_verified == true) {
            $data->is_verified = false;
        } else {
            $data->is_verified = true;
        }
        $data->save();

        Alert::toast('Verifikasi Berhasil', 'success');
        return back();
    }
}
