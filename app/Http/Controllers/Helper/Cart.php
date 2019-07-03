<?php 
namespace App\Http\Controllers\Helper;
//session_start();

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
				'image' => $item['image']
			];
		} else {
			$cart['quantity'] = $cart['quantity'] + $item['quantity'];
		}

		$this->setItemCart($id, $cart);
	}

	public function setItemCart($id, $cart) {
		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}

		$_SESSION['cart'][$id] = $cart;
	}

	// public function getItemCart($id) {
	// 	if (!isset($_SESSION['cart'])) {
	// 		$_SESSION['cart'] = [];
	// 	}

	// 	$_SESSION['cart'][$id] = $cart;
	// }

	public function getAllCart() {
		if (isset($_SESSION['cart'])) {
			return $_SESSION['cart'];
		}
		return [];
	}

	public function getCart($id) {
		if (isset($_SESSION['cart'][$id])) {
			return $_SESSION['cart'][$id];
		}
		return [];
	}

	public function countAllCart() {
		return count($this->getAllCart());
	}

	public function remove_cart() {
		
	}
}
 ?>