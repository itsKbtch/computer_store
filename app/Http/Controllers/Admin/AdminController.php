<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profile.index');
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
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    public function change_password_form() {
        return view('admin.profile.changepassword');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $admin = $admin->findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|max:191',
            'username' => 'required',
            'email' => 'required'
        ]);

        if ($request->username != $admin->username) {
            $request->validate([
                'username' => 'regex:/^[\w]*$/|min:5|unique:admins|max:50'
            ]);
        }

        if ($request->email != $admin->email) {
            $request->validate([
                'email' => 'email|unique:admins|max:191'
            ]);
        }

        $admin = $admin->fill($request->all());

        $check = $admin->save();

        if ($check) {
            return back()->with('success', 'Cập nhật thành công');
        }

        return back()->with('fail', 'Cập nhật thất bại');
    }

    public function change_password(Request $request, Admin $admin) {
        $admin = $admin->findOrFail(Auth::id());

        $request->validate([
            'new_password' => 'required|alpha_num|min:8|max:50',
            'confirm_new_password' => 'required|alpha_num|same:new_password|min:8|max:50',
            'current_password' => 'required|alpha_num|max:50'
        ]);

        if (Hash::check($request->current_password, $admin->password)) {
            $hashed = Hash::make($request->new_password);
            $admin->password = $hashed;
            $check = $admin->save();

            if ($check) {
                return back()->with('success', 'Đổi mật khẩu thành công');
            }

            return back()->with('fail', 'Đổi mật khẩu thất bại');
        }

        return back()->with('fail', 'Mật khẩu hiện tại không chính xác');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
