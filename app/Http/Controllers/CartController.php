<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Promo_code;
use App\Invoice;
use App\Http\Controllers\Helper\Cart;
use Auth;

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
                'discount_percent' => $product->discount_percent,
                'discount_cash' => $product->discount_cash,
    			'quantity' => 1
    		];

    		Cart::getInstance()->addCart($id, $item);

    		return redirect('cart/list')->with('success', 'Thêm thành công');
    	}

    	return back()->with('fail', 'Thêm thất bại');
    }

    public function cart_list() {
    	return view('cart.cartlist');
    }

    public function remove_cart(Request $request) {
        if (Cart::getInstance()->removeItemCart($request->id)) {
            return response()->json(['status' => 'success']);
        }
    	
    	return response()->json(['status' => 'fail']);
    }

    public function update_cart(Request $request) {
        if (!empty($request->cart)) {
            foreach ($request->cart as $id => $quantity) {
                Cart::getInstance()->updateItemCart($id, $quantity);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    }

    public function apply_promo_code(Request $request) {
        $promo = Promo_code::whereRaw("BINARY active_code = ?", $request->active_code)->where('active', 1)->get();

        if (!$promo->isEmpty()) {
            $promo = $promo->first();

            if ($promo->quantity > 0) {

                if (strtotime($promo->end_time) > time()) {
                    return response()->json([
                        'status' => 'success',
                        'promo' => $promo
                    ]);
                } 

                return response()->json([
                    'status' => 'out of date'
                ]);
            }

            return response()->json([
                'status' => 'out of stock'
            ]);
        }

        return response()->json(['status' => 'fail']);
    }

    public function checkout() {
        $carts = Cart::getInstance()->getAllCart();

        if (empty($carts)) {
            return redirect()->route('cartList');
        }

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = [];
        }

        return view('cart.checkout', ['user' => $user]);
    }

    public function placeorder(Request $request) {
        $request->validate([
            'name' => 'required|string|max:191',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^0{1}[35789]{1}[0-9]{8}$/',
            'email' => 'nullable|email',
            'user_id' => 'nullable|exists:users,id|integer',
            'promo_code' => 'nullable|exists:promo_code,id|integer',
            'total' => 'required|integer|min:0',
            'total_with_discount' => 'required|integer|min:0'
        ]);

        $invoice = new Invoice;

        $invoice = $invoice->fill($request->except('promo_code'));

        if ($invoice->total_with_discount < 0) {
            $invoice->total_with_discount = 0;
        }

        if ($request->filled('promo_code')) {
            $promo = Promo_code::where('active', 1)->where('quantity', '>', 0)->where('id', $request->promo_code);

            if ($promo->exists()) {
                $promo = $promo->first();
                $invoice->discount_percent = $promo->discount_percent;
                $invoice->discount_cash = $promo->discount_cash;
                $promo->quantity--;

                $promo->save();
            }
        }

        if (!empty(Cart::getInstance()->getAllCart())) {
            $invoice->save();

            foreach (Cart::getInstance()->getAllCart() as $item) {
                $invoice->items()->attach($item['id'], ['quantity' => $item['quantity'], 'discount_percent' => $item['discount_percent'], 'discount_cash' => $item['discount_cash']]);
            }

            Cart::getInstance()->destroyCart();

            return redirect()->route('placeorder.success', [$invoice->id]);
        }

        return back()->with('fail', 'Có lỗi xảy ra không thể đặt hàng vui lòng thử lại sau');
    }

    public function placeorder_success($id) {
        $invoice = Invoice::find($id);

        if (empty($invoice)) {
            return redirect()->route('notfound');
        }

        return view('cart.success', ['invoice' => $invoice]);
    }
}
