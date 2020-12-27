<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{

    public function delivery() {
        $title = 'Chính sách giao hàng';
        return view('sitepages.policy.deliveryPolicy', compact('title'));
    } 
    public function payment() {
        $title = 'Chính sách thanh toán';
        return view('sitepages.policy.paymentPolicy', compact('title'));
    } 
    public function return() {
        $title = 'Chính sách đổi trả';
        return view('sitepages.policy.returnPolicy', compact('title'));
    } 
}
