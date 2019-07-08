<?php

namespace App\Http\Controllers\Admin;

use App\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Shop::first();

        return view('admin.shop.info', ['info' => $info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $info)
    {
        $request->validate([
            'phone_number' => 'required|string|max:11|regex:/^0{1}[35789]{1}[0-9]{8}$/', 
            'email' => 'required|string|email|max:191', 
            'address' => 'required|string|max:255', 
            'facebook' => 'required|url|max:191', 
            'open_time' => 'required|string|max:191', 
            'about' => 'required|string'
        ]);

        $info = $info->first();

        $check = false;

        if (empty($info)) {
            $info = new Shop;
            $info = $info->fill($request->all());
            $check = $info->save();
        } else {
            $info = $info->fill($request->all());
            $check = $info->save();
        }


        if ($check) {
            return back()->with('success', 'Cập nhật thông tin thành công');
        }

        return back()->with('fail', 'Cập nhật thông tin thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
