<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\PriceRange;
use App\Models\Comment;
use App\Models\Brand;

class ProductController extends Controller
{
    //
    private $title = 'Sản phẩm';
    public function details(Request $request) {
        $product = Product::where('id', $request->id)->first();
        $category = Category::find($product->category_id);
        $categories = Category::all();
        $comments = Comment::where('product_id', $request->id)->skip(0)->take(5)->orderBy('created_date', 'desc')->get();
        $description = isset($request->description);
        $amount = Comment::where('product_id', $request->id)->count();
        $still = $amount > 5;
        $brand = Brand::where('id', $product->brand_id)->first();
        // Lấy danh sách điều kiện Price
        $prices = PriceRange::all();
        $price_ranges = [];
        foreach ($prices as $price) {
            $min = $price->min_price != '0' ? $price->min_price : 'less' ;
            $max = $price->max_price != 'very' ? $price->max_price : 'greater';

            $price_ranges[] = ['min' => $min, 'max' => $max];
        }
        $title = $this->title;
        $price = $product->price;
        $min = ($price - 200000 > 0) ? ($price - 200000) : 0;
        $max = $price + 200000;
        $related_products = Product::where('category_id', $product->category_id)->limit(20)->get();
        $related_products = $related_products->merge(Product::where('brand_id', $product->brand_id)->limit(10)->get());
        $related_products = $related_products->merge(Product::whereBetween('price', [$min, $max])->limit(10)->get());
        $related_products = $related_products->shuffle();
        return view('sitepages.product.productDetails', compact('brand', 'related_products', 'product', 'categories', 'comments', 'description', 'still', 'category', 'price_ranges', 'title'));
    }

    public function products($category_id, Request $request) {
        $min = $request->min;
        $max = $request->max;
        $column = $request->column;
        $orderBy = $request->orderBy;
        $price_range = empty($min) ? "" : ($min . '-' . $max);
        $sortSelected = empty($column) ? "default-default" : ($column . '-' . $orderBy);
        extract($this->getProduct(compact('category_id', 'min', 'max', 'column', 'orderBy')));
        $title = $this->title;
        return view('sitepages.product.products', compact('category', 'products', 'categories', 'price_ranges', 'price_range', 'sortSelected', 'title'));
    }

    public function getProduct($resources) {

        // Khởi tạo products
        $products = Product::select("*");

        // Giải nén các biến 
        extract($resources);

        // Nếu có điều kiện Sort
        if (!empty($column) && !empty($orderBy && $column != 'default')) {
            $products->orderBy($column, $orderBy);
        }

        // Nếu có điều kiện Price
        if (!empty($min) && !empty($max)) {
            if ($min == 'less') {
                $products = $products->where('sale_price', "<", $max);
            }
            else {
                if ($max == 'greater') {
                    $products = $products->where('sale_price', ">", $min);
                }
                else {
                    $products = $products->whereBetween('sale_price', [$min, $max]);
                }
            }
        }

        // Chọn Category đúng yêu cầu 
        // Lấy Category hiện hành, all = null
        $category = null;
        if (!empty($category_id)) {
            if ($category_id != 'all') {
                $category = Category::where('id', $category_id)->first();
                $products = $products->where('category_id', $category_id);
            }
        }

        // Phân trang 
        $products = $products->paginate(9);

        // Lấy danh sách Category
        $categories  = Category::get();

        // Lấy danh sách điều kiện Price
        $prices = PriceRange::all();
        $price_ranges = [];
        foreach ($prices as $price) {
            $min = $price->min_price != '0' ? $price->min_price : 'less' ;
            $max = $price->max_price != 'very' ? $price->max_price : 'greater';

            $price_ranges[] = ['min' => $min, 'max' => $max];
        }

        // Trả về 
        return compact('products', 'category', 'price_ranges', 'categories');
    }

    public function comment(Request $request) {
        $amount = 5;
        $comment = new Comment;
        $comment->product_id = $request->product_id;
        $comment->star = $request->star;
        $comment->fullname = $request->fullname;
        $comment->email = $request->email;
        $comment->description = $request->description;
        $comment->save();
        return redirect()->route('product.details', ['id' => $request->product_id, 'description' => true]);
    }   

    public function nextComment(Request $request) {
        $comments = Comment::where('product_id', $request->product_id)->orderBy('created_date', 'desc')->skip($request->current)->take($request->amount)->get();
        $amount = Comment::count();
        $still = $amount > ($request->current + $request->amount);
        echo json_encode(compact('comments', 'still'));
    }


    public function addCart(Request $request) {
        // input id, amount
        $id = $request->id;
        $amount = $request->amount;

        $totalAll = 0;
        $totalProduct = 0;
        
        $products = session()->pull('products');

        $check = false;
        $product = null;

        if ($products != null) {
            foreach ($products as $index => $pack) {
                if ($pack['product']->id == $id) {
                    $products[$index]['amount'] = $amount;
                    $totalProduct = $amount * $pack['product']->sale_price;
                    $totalAll += $totalProduct;
                    $check = true;
                }
                else {
                    $totalAll += $pack['amount'] * $pack['product']->sale_price;
                }
            }
        }

        if (!$check || $products == null) {
            $product = Product::find($id);
            // dd($id);
            $totalAll += $product->sale_price * $amount;
            $totalProduct = $product->sale_price;
            $products[] = ['amount' => 1, 'product' => $product];
        }

        session(['products' => $products]);
        session(['totalAll' => $totalAll]);
        // echo $totalAll . '<br>';
        // return totalAll, totalProduct
        echo json_encode(compact('product', 'totalAll', 'totalProduct'));
    }
    public function deleteCart(Request $request) {
        $amount = $request->amount;
        $id = $request->id;
        $products = session()->pull('products');
        $totalAll = 0;
        if ($products != null) {
            foreach ($products as $index => $_product) {
                if ($_product['product']->id == $id) {
                    unset($products[$index]);
                }
                else {
                    $totalAll += $_product['product']->sale_price * $_product['amount'];
                }
            }
        }
        session(['total-price' => $totalAll]);
        session(['products' => $products]);
        $amount = count($products);
        echo json_encode(compact('amount', 'totalAll'));
    }
}
