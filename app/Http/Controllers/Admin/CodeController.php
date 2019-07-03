<?php

namespace App\Http\Controllers\Admin;

use App\Promo_code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codes = new Promo_code;

        if (isset($_GET['filters'])) {
            foreach ($_GET['filters'] as $filter) {
                if ($filter == 'ended') {
                    $codes = $codes->where('end_time', '<' , date('Y-m-d h:i:s', time()));
                }
                if ($filter == 'ongoing') {
                    $codes = $codes->where('end_time', '>=' , date('Y-m-d h:i:s', time()));
                }
                if ($filter == 'active') {
                    $codes = $codes->where('active', 1);
                }
                if ($filter == 'inactive') {
                    $codes = $codes->where('active', 0);
                }
                if ($filter == 'available') {
                    $codes = $codes->where('quantity', '>', 0);
                }
                if ($filter == 'out') {
                    $codes = $codes->where('quantity', '<=', 0);
                }
            }
        }

        if (isset($_GET['keyword'])) {
            $codes = $codes->where('active_code', 'like', '%'.$_GET['keyword'].'%');
        }
        
        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'new') {
                $codes = $codes->orderBy('created_at', 'desc');
            };
            if ($_GET['sort'] == 'old') {
                $codes = $codes->orderBy('created_at', 'asc');
            };
        } else {
            $codes = $codes->orderBy('created_at', 'desc');
        }

        $codes = $codes->paginate(10)->appends($_GET);

        return view('admin.code.index', ['codes' => $codes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.code.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'active_code' => 'required|unique:promo_code|max:50',
            'discount_percent' => 'sometimes|required|integer|max:100',
            'discount_cash' => 'sometimes|required|integer|min:0',
            'end_time' => 'required|date|after:today',
            'quantity' => 'required|integer|max:32767|min:0',
            'active' => 'nullable|boolean'
        ]);

        $code = new Promo_code;
        $code = $code->fill($request->except('active'));

        if (!empty($request->active)) {
            $code->active = 1;
        } else {
            $code->active = 0;
        } 

       $check = $code->save();

       if ($check) {
           return redirect('admin/code')->with('success', 'Thêm mới thành công');
       }

       return back()->with('fail', 'Thêm mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo_code  $promo_code
     * @return \Illuminate\Http\Response
     */
    public function show(Promo_code $promo_code, $id)
    {
        $promo_code = $promo_code->findOrFail($id);

        return view('admin.code.details', ['code' => $promo_code]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo_code  $promo_code
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo_code $promo_code, $id)
    {
        $promo_code = $promo_code->findOrFail($id);

        return view('admin.code.edit', ['code' => $promo_code]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo_code  $promo_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo_code $promo_code, $id)
    {
        $promo_code = $promo_code->findOrFail($id);

        if ($promo_code->active_code == $request->active_code) {
            $request->validate([
                'discount_percent' => 'sometimes|required|integer|max:100',
                'discount_cash' => 'sometimes|required|integer|min:0',
                'end_time' => 'required|date|after:today',
                'quantity' => 'required|integer|max:32767|min:0',
                'active' => 'nullable|boolean'
            ]);
        } else {
            $request->validate([
                'active_code' => 'required|unique:promo_code|max:50',
                'discount_percent' => 'sometimes|required|integer|max:100',
                'discount_cash' => 'sometimes|required|integer|min:0',
                'end_time' => 'required|date|after:today',
                'quantity' => 'required|integer|max:32767|min:0',
                'active' => 'nullable|boolean'
            ]);
        }

        $promo_code = $promo_code->fill($request->except('active'));

        if (!empty($request->active)) {
            $promo_code->active = 1;
        } else {
            $promo_code->active = 0;
        } 

        $check = $promo_code->save();

        if ($check) {
            return back()->with('success', 'Chỉnh sửa thành công');
        }

        return back()->with('fail', 'Chỉnh sửa thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo_code  $promo_code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo_code $promo_code, $id)
    {
        $promo_code = $promo_code->findOrFail($id);

        $check = $promo_code->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }

    public function destroyMany(Promo_code $promo_code, Request $request)
    {
        $promo_code = $promo_code->whereIn('id', $request->id);

        $check = $promo_code->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }
}
