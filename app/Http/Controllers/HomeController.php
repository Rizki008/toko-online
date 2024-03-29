<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // dd(Auth::guard('webmember')->user());
        $sliders = Slider::all();
        $categories = Category::all();
        $testimonis = Testimoni::all();
        $products = Product::skip(0)->take(8)->get();
        return view('home.index', compact('sliders', 'categories', 'testimonis', 'products'));
    }

    public function products($id_subkategory)
    {
        $products = Product::where('id_subkategori', $id_subkategory)->get();

        return view('home.products', compact('products'));
    }
    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Cart::create($input);
    }
    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }
    public function product($id_product)
    {
        $product = Product::find($id_product);
        $latest_products = Product::orderByDesc('created_at')->offset(0)->limit(10)->get();
        return view('home.product', compact('product', 'latest_products'));
    }

    public function cart()
    {
        $carts = Cart::where('id_member', Auth::guard('webmember')->user()->id)->get();
        return view('home.cart', compact('carts'));
    }

    public function checkout()
    {
        return view('home.checkout');
    }

    public function orders()
    {
        return view('home.orders');
    }

    public function about()
    {
        $about = About::first();
        $testimonis = Testimoni::all();
        return view('home.about', compact('about', 'testimonis'));
    }

    public function contact()
    {
        $about = About::first();
        return view('home.contact', compact('about'));
    }

    public function faq()
    {
        return view('home.faq');
    }
}
