<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $title = 'Liên hệ';
    //
    public function contact() {
        $title = $this->title;
        return view('sitepages.contact', compact('title'));
    }
}
