<?php

namespace App\Http\Controllers\Admin;

use App\Promotion;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = new Promotion;

        if (isset($_GET['filters'])) {
            foreach ($_GET['filters'] as $filter) {
                if ($filter == 'ended') {
                    $promos = $promos->where('end_time', '<' , date('Y-m-d h:i:s', time()));
                }
                if ($filter == 'ongoing') {
                    $promos = $promos->where('end_time', '>=' , date('Y-m-d h:i:s', time()));
                }
                if ($filter == 'active') {
                    $promos = $promos->where('active', 1);
                }
                if ($filter == 'inactive') {
                    $promos = $promos->where('active', 0);
                }
            }
        }

        if (isset($_GET['keyword'])) {
            $promos = $promos->where('name', 'like', '%'.$_GET['keyword'].'%');
        }
        
        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'new') {
                $promos = $promos->orderBy('created_at', 'desc');
            };
            if ($_GET['sort'] == 'old') {
                $promos = $promos->orderBy('created_at', 'asc');
            };
        } else {
            $promos = $promos->orderBy('created_at', 'desc');
        }

        $promos = $promos->paginate(10)->appends($_GET);

        return view('admin.promo.index', ['promos' => $promos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promo.create');
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
            'name' => 'required|unique:promotion|max:191',
            'content' => 'required',
            'end_time' => 'required|date|after:today',
            'active' => 'nullable|boolean'
        ]);

        $promo = new Promotion;
        $promo->fill($request->except('active'));

        if (!empty($request->active)) {
            $promo->active = 1;
        } else {
            $promo->active = 0;
        }

        $check = $promo->save();

        if ($check) {
            return redirect('admin/promo')->with('success', 'Thêm mới thành công');
        }

        return back()->with('fail', 'Thêm mới thất bại');
    }

    public function apply_show($id) {
        $promo = Promotion::with('products')->findOrFail($id);

        $ids = $promo->products->map(function($item) {
            return $item->id;
        });

        $products = Product::whereNotIn('id', $ids)->get();

        return view('admin.promo.apply', ['products' => $products, 'promo' => $promo]);
    }

    public function apply(Promotion $promo, Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'required|integer'
        ]);

        $promo = $promo::with('products')->findOrFail($id);

        if (!$promo->products->whereIn('id', $request->products)->isEmpty()) {
            return back()->with('fail', 'Có sản phẩm đã đc áp dụng');
        }

        $promo->products()->attach($request->products);

        if ($promo->products()->whereIn('id', $request->products)->exists()) {
            return redirect('admin/promo')->with('success', 'Áp dụng thành công');
        }

        return back()->with('fail', 'Áp dụng thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promo, $id)
    {
        $promo = $promo::with('products')->findOrFail($id);

        return view('admin.promo.details', ['promo' => $promo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promo, $id)
    {
        $promo = $promo::with('products')->findOrFail($id);

        return view('admin.promo.edit', ['promo' => $promo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Promotion $promo, Request $request, $id)
    {
        $promo = $promo->findOrFail($id);

        if (strtolower($promo->name) == strtolower($request->name)) {
            $request->validate([
                'content' => 'required',
                'end_time' => 'required|date|after:today'
            ]);
        } else {
            $request->validate([
                'name' => 'required|unique:promotion|max:191',
                'content' => 'required',
                'end_time' => 'required|date|after:today'
            ]);
        }

        $promo->fill($request->except('active'));

        if (!empty($request->active)) {
            $promo->active = 1;
        } else {
            $promo->active = 0;
        }

        $check = $promo->save();

        if ($check) {
            return back()->with('success', 'Chỉnh sửa thành công');
        }

        return back()->with('fail', 'Chỉnh sửa thất bại');
    }

    public function unapply(Promotion $promo, $id, $product_id) {
        $promo = $promo->findOrFail($id);
        $promo->products()->detach($product_id);

        if (!$promo->products()->where('id', $product_id)->exists()) {
            return back()->with('success', 'Ngừng áp dụng thành công');
        }

        return back()->with('fail', 'Ngừng áp dụng thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promo, $id)
    {
        $promo = $promo->findOrFail($id);

        $promo->products()->detach();

        $check = $promo->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'fail'
        ]);
    }

    public function destroyMany(Promotion $promos, Request $request)
    {
        $promos = $promos->whereIn('id', $request->id);

        foreach ($promos->get() as $promo) {
            $promo->products()->detach();
        }

        $check = $promos->delete();

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
