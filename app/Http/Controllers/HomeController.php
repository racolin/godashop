<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    private $title = 'Trang chủ';
    public function home() {
        $title = $this->title;
        $categories = Category::all();
        $allTypeProducts = [];
        $amount = 4;
        $products = Product::orderBy('created_date','desc')->limit(8)->get();
        $allTypeProducts['Sản phẩm mới nhất'] =  compact('products');
        foreach ($categories as $category) {
            $caption = $category->name;
            $request = new Request([
                'category_id' => $category->id,
                'current' => 0,
                'amount' => $amount
            ]);
            $request->setMethod('GET');
            $allTypeProducts[$caption] =  $this->nextProduct($request);
        }
        return view('sitepages.homePage', compact('title', 'allTypeProducts'));
    }

    public function nextProduct(Request $request) {
        // Input:  $category_id, $current, $amount, $ajax 
        // Output: $products, $still
        // dd([$request->current, $request->amount, $request->category_id]);
        $count = Product::where('category_id', $request->category_id)->count();
        $products = Product::where('category_id', $request->category_id)->get();
        // $still = $count > ($request->current + $request->amount);
        if (!isset($request->ajax)) {
            // return compact('still', 'products');
            return compact('products');
        }
        echo json_encode(compact('still', 'products'));
        echo json_encode(compact('products'));
    }
}
