<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;

use App\User;

use Illuminate\Support\Facades\Hash;

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
    	$invoices = Auth::user()->invoices()->orderBy('created_at', 'desc')->get();

    	return view('account.orders', ['invoices' => $invoices]);
    }

    public function order_details($id) {
    	$invoice = Invoice::findOrFail($id);

    	return view('account.orderdetails', ['invoice' => $invoice]);
    }

    public function change_password_form() {
    	return view('account.changepassword');
    }

    public function update_info(User $user, Request $request) {
        $user = $user->findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'phone_number' =>  'required|string|max:11|regex:/^0{1}[35789]{1}[0-9]{8}$/',
            'address' => 'required|string|max:255'
        ]);

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);
        }

        if ($user->phone_number != $request->phone_number) {
            $request->validate([
                'phone_number' => 'unique:users'
            ]);
        }

        $user = $user->fill($request->all());

        $check = $user->save();

        if ($check) {
            return back()->with('success', 'Cập nhật thành công');
        }

        return back()->with('fail', 'Cập nhật thất bại');
    }

    public function change_password(Request $request, User $user) {
        $user = $user->findOrFail(Auth::id());

        $request->validate([
            'new_password' => 'required|alpha_num|min:8|max:50',
            'confirm_new_password' => 'required|alpha_num|same:new_password|min:8|max:50',
            'current_password' => 'required|alpha_num|max:50'
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $hashed = Hash::make($request->new_password);
            $user->password = $hashed;
            $check = $user->save();

            if ($check) {
                return back()->with('success', 'Đổi mật khẩu thành công');
            }

            return back()->with('fail', 'Đổi mật khẩu thất bại');
        }

        return back()->with('fail', 'Mật khẩu hiện tại không chính xác');
    }

    public function cancel_order(Invoice $invoice, $id) {
        $invoice = $invoice->findOrFail($id);

        if ($invoice->status != 0) {
            return back()->with('fail', 'Không thể hủy đơn hàng lúc này vui lòng thử lại sau');
        }

        $invoice->status = 2;

        $check = $invoice->save();

        if ($check) {
            return back()->with('success', 'Đã hủy đơn hàng '.$id);
        } 

        return back()->with('fail', 'Không thể hủy đơn hàng lúc này vui lùng thử lại sau');
    }

    public function confirm_delete_account() {
        return view('account.confirmdelete');
    }

    public function delete_account(Request $request, User $user) {
        $user = $user->with('invoices')->findOrFail(Auth::id());

        if (Hash::check($request->password, $user->password)) {

            foreach ($user->invoices as $invoice) {
                $invoice->user()->dissociate()->save();
            }

            $check = $user->delete();

            if ($check) {
                Auth::logout();

                return redirect()->route('login');
            }

            return back()->with('fail', 'Không thể xóa tài khoản vui lòng thử lại sau');;
        }

        return back()->with('fail', 'Mật khẩu hiện tại không chính xác');
    }
}
