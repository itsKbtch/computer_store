<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;

use Auth;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index() {
    	return view('account.info');
    }

    public function orders() {
    	$invoices = Auth::user()->invoices;

    	return view('account.orders', ['invoices' => $invoices]);
    }

    public function order_details($id) {
    	$invoice = Invoice::findOrFail($id);

    	return view('account.orderdetails', ['invoice' => $invoice]);
    }

    public function change_password_form() {
    	return view('account.changepassword');
    }
}
