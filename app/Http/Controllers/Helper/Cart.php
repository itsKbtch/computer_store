<?php 
namespace App\Http\Controllers\Helper;
use Session;

/**
 * 
 */
class Cart
{
	public static function getInstance() {
		return new static();
	}

	public function addCart($id, $item) {
		$cart = $this->getCart($id);
		
		if (empty($cart)) {
			$cart = [
				'name' => $item['name'],
				'quantity' => $item['quantity'],
				'id' => $item['id'],
				'price' => $item['price'],
				'discount_percent' => $item['discount_percent'],
                'discount_cash' => $item['discount_cash'],
				'image' => $item['image']
			];
		} else {
			$cart['quantity'] = $cart['quantity'] + $item['quantity'];
		}

		$this->setItemCart($id, $cart);
	}

	public function setItemCart($id, $cart) {
		if (!Session::has('cart')) {
			Session::put('cart', []);
		}

		$newCart = Session::get('cart');
		$newCart[$id] = $cart;

		Session::put('cart', $newCart);
	}

	public function getAllCart() {
		return Session::get('cart', []);
	}

	public function getCart($id) {
		return Session::get('cart.'.$id, []);
	}

	public function countAllCart() {
		return count($this->getAllCart());
	}

	public function removeItemCart($id) {
		$cart = $this->getCart($id);

		if (!empty($cart)) {
			Session::forget('cart.'.$id);
			return true;
		}

		return false;
	}

	public function updateItemCart($id, $quantity) {
		$cart = $this->getCart($id);

		if (!empty($cart)) {
			$cart['quantity'] = $quantity;
			$this->setItemCart($id, $cart);
			
			return true;
		}

		return false;
	}

	public function destroyCart() {
		if (Session::has('cart')) {
			Session::forget('cart');
		}
	}
}
 ?>