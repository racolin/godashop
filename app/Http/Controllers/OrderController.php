<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Transport;

class OrderController extends Controller
{
    //
    public function order() {
        $provinces = Province::all();
        $districts = null;
        $wards = null; 
        $ward_id = null; 
        $district_id = null;
        $province_id = null;
        $transport = 0;
        if (!empty(session('customer'))) {
            $customer = session('customer');
            $ward = Ward::find($customer->ward_id); 
            $district = District::find($ward->district_id);
            $province = Province::find($district->province_id);
            $districts = District::all();
            $wards = Ward::all();
            $ward_id = $ward->id; 
            $district_id = $district->id;
            $province_id = $province->id;
            $transport = Transport::whereRaw("province_id = $province_id")->first()->price;
        }
        return view('sitepages.order.order', compact('provinces', 'province_id', 'districts', 'district_id', 'wards', 'ward_id', 'transport'));
    }

    public function getDistricts(Request $request) {
        $districts = District::whereRaw("province_id = $request->id")->get();
        $transport = Transport::whereRaw("province_id = $request->id")->first()->price;
        echo json_encode([$districts, $transport]); 
    }

    public function getWards(Request $request) {
        $wards = Ward::whereRaw("district_id = $request->id")->get();
        echo $wards->toJson(); 
    }

    public function payment() {
        // Xử lý đặt hàng 
        // Nếu có tài khoản thì gửi mail xác thực
        // Nếu vãng lai thì đặt luôn (thực tế thì đưa qua bảng khách vãng lai để nhân viên gọi check)
        return view('sitepages.order.payment');
    }
}
