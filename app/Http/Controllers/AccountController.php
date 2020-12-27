<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class AccountController extends Controller
{
    //
    public function addressDefault() {
        $provinces = Province::all();
        $districts = District::get();
        $wards = Ward::get();
        if (!session()->has('customer') || session('customer')->ward_id == null) {
            return view('sitepages.account.addressDefault', compact('provinces'));
        }
        $ward = Ward::where('id', session('customer')->ward_id)->first();
        $district = District::where('id', $ward->district_id)->first();
        $province = Province::where('id', $district->province_id)->first();
        // dd([$ward->name, $district->name, $province->name, ]);
        // dd($provinces);
        return view('sitepages.account.addressDefault', compact('provinces', 'districts', 'wards', 'province', 'district', 'ward'));
    }

    public function updateAddress(Request $request) {
        $customer = Customer::find(session('customer')->id);
        $customer->ward_id = $request->ward;
        $customer->shipping_name = $request->fullname;
        $customer->shipping_mobile = $request->mobile;
        $customer->housenumber_street = $request->housenumber_street;
        $customer->update();
        // Lỗi không update raw ''
        session(['customer' => $customer]);
        return redirect()->route('account.addressDefault');
    }

    public function logout() {
        session()->forget('customer');
        return redirect()->route('home');
    }

    public function login(Request $request) {
        session()->forget('customer');
        $customer = Customer::where('email', $request->email)->first();
        if (!empty($customer) && $customer->password == $request->password) {
            session(['customer' => $customer]);
        }
        return redirect()->route('home');
    }

    public function info() {
        return view('sitepages.account.info');
    }

    public function listOrder() {
        return view('sitepages.account.listOrder');
    }

    public function orderDetails() {
        return view('sitepages.account.orderDetails');
    }

    public function signup(Request $request) {
        $check = count(Customer::where('email', $request->email)->get()) == 0;
        if ($check) {
            Customer::insert([
                'email' => $request->email, 'password' => $request->password, 'name' => $request->fullname, 
                'mobile' =>$request->mobile, 'login_by' => 'form', 'shipping_name' => $request->fullname, 'shipping_mobile' => $request->mobile
            ]);
            $customer = Customer::where('email', $request->email)->first();
            session(['customer' => $customer]);
        }
        return redirect()->route('home');
    }

    public function check(Request $request) {
        $check = count(Customer::where('email', $request->email)->get());
        echo $check;
    }
}
