<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Controllers\Helper\Cart;

session_start();

class CartController extends Controller
{
    public function add_cart(Request $request) {
    	$id = $request->id;

    	$product = Product::findOrFail($id);

    	if (isset($product)) {
    		$item = [
    			'name' => $product->name,
    			'id' => $product->id,
    			'price' => $product->price,
    			'image' => $product->photos->isEmpty()? '':$product->photos[0]->name,
    			'quantity' => 1
    		];

    		Cart::getInstance()->addCart($id, $item);

    		return redirect('cart/list')->with('success', 'Thêm thành công');
    	}

    	return back()->with('fail', 'Thêm thất bại');
    }

    public function cart_list() {
        if (isset($_SESSION['cart'])) {
            $carts = $_SESSION['cart'];
        } else {
            $carts = [];
        }

    	$categories = Category::with(['subCategories'])->whereNull('parent_id')->where('active', 1)->get();

    	return view('cart.cartlist', ['categories' => $categories, 'carts' => $carts]);
    }

    public function remove_cart(Request $request) {
    	
    	return response()->json(['a' => 1]);
    }
}
