<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Product;
use App\Invoice;
use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    function index() {
        $bestSellers = new Product;

        $bestSellers = $bestSellers->withSales()->with('photos')->orderBy('sales', 'desc')->limit(5)->get();

        $invoiceTotal = 0;
        $invoiceData = [];

        for ($i=6; $i >= 0; $i--) {
            $daily = Invoice::whereDate('created_at', date('Y-m-d', strtotime("-".$i." days")))->count();
            array_push($invoiceData, $daily);
            $invoiceTotal = $invoiceTotal + $daily;
        }

        $userTotal = 0;
        $userData = [];

        for ($i=6; $i >= 0; $i--) {
            $daily = User::whereDate('created_at', date('Y-m-d', strtotime("-".$i." days")))->count();
            array_push($userData, $daily);
            $userTotal = $userTotal + $daily;
        }

    	return view('admin.home.index', [
            'bestSellers' => $bestSellers, 
            'invoiceData' => [
                'total' => $invoiceTotal,
                'daily' => $invoiceData
            ], 
            'userData' => [
                'total' => $userTotal,
                'daily' => $userData
            ]
        ]);
    }
}
