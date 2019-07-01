<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Category;
use App\Photos;
use App\Details;
use App\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['categories', 'promotion']);

        $categories = category::all();
        $mainCategories = $categories->where('parent_id', NULL);
        $subCategories = $categories->where('parent_id', '!=', NULL);

        if (isset($_GET['category'])) {
            // $ids = [];
            // foreach ($_GET['category'] as $category) {
            //     foreach ($categories->find($category)->products as $product) {
            //        array_push($ids, $product->id);
            //     }
            // }
            // $products = $products->whereIn('id', $ids);
            foreach ($_GET['category'] as $category) {
                $products = $products->whereHas('categories', function($query) use ($category) {
                    $query->where('category_id', $category);
                });
            }
        }

        if (isset($_GET['filters'])) {
            foreach ($_GET['filters'] as $filter) {
                if ($filter == 'active') {
                    $products = $products->where('active', 1);
                };
                if ($filter == 'inactive') {
                    $products = $products->where('active', 0);
                };
                if ($filter == 'discount') {
                    $products = $products->whereNotNull('discount_end_time');
                };
                if ($filter == 'promoted') {
                    $products = $products->has('promotion');
                };
            }
        }

        if (isset($_GET['status'])) {
            foreach ($_GET['status'] as $status) {
                $products = $products->where('status', $status);
            }
        }

        if (isset($_GET['keyword'])) {
            $products = $products->where('name', 'like', '%'.$_GET['keyword'].'%');
        }

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'new') {
                $products = $products->orderBy('created_at', 'desc');
            };
            if ($_GET['sort'] == 'old') {
                $products = $products->orderBy('created_at', 'asc');
            };
            if ($_GET['sort'] == 'priceAsc') {
                $products = $products->orderBy('price', 'asc');
            };
            if ($_GET['sort'] == 'priceDesc') {
                $products = $products->orderBy('price', 'desc');
            };
        } else {
            $products = $products->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(12)->appends($_GET);

        return view('admin.stock.index', ['products' => $products, 'mainCategories' => $mainCategories, 'subCategories' => $subCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('active', 1)->get();
        $promos = Promotion::where('active', 1)->get();

        return view('admin.stock.create', ['categories' => $categories, 'promos' => $promos]);
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
            'name' => 'required|unique:product|max:255',
            'price' => 'required|integer',
            'warranty' => 'required|integer|max:127',
            'in_stock' => 'required|integer|max:127',
            'status' => 'required|integer',
            'description' => 'required|string',
            'photos' => 'nullable',
            'photos.*' => 'image|max:2048',
            'active' => 'nullable|boolean',
            'discount_percent' => 'sometimes|required_with:discount_end_time|nullable|integer|max:100',
            'discount_cash' => 'sometimes|required_with:discount_end_time|nullable|integer',
            'discount_end_time' => 'required_with:discount_percent,discount_cash|nullable|date|after:today',
            'categories' => 'required',
            'categories.*' => 'integer',
            'details' => 'nullable',
            'details.*.name' => 'required_with:details|string|max:50',
            'details.*.value' => 'required_with:details|string|max:255',
            'promos' => 'nullable|array',
            'promos.*' => 'required_with:promos|integer'
        ]);

        $product = new Product;

        $product->fill($request->except(['categories', 'details', 'photos', 'active']))->save();

        if (!empty($request->active)) {
            $product->active = 1;
        } else {
            $product->active = 0;
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $image = time() . "-" . $photo->getClientOriginalName();
                $photo->storeAs("public/product", $image);
                $product->photos()->save(new Photos(['name' => $image]));
            }
        }

        $product->categories()->attach($request->categories);

        if (!empty($request->promos)) {
            $product->promotion()->attach($request->promos);
        }

        if (!empty($request->details)) {
            foreach ($request->details as $detail) {
                $product->details()->save(new Details($detail));
            }
        }
        
        $check = $product->save();
        if ($check) {
            return redirect('admin/stock')->with('success', 'Thêm mới thành công');
        }
        return back()->with('fail', 'Thêm mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id)
    {
        $product = $product->with(['categories', 'promotion' => function($query) {
            $query->where('active', 1);
        }])->findOrFail($id);

        return view('admin.stock.details', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id)
    {
        $product = $product->with(['categories', 'promotion'])->findOrFail($id);
        $categories = Category::where('active', 1)->get();
        $promos = Promotion::where('active', 1)->get();

        return view('admin.stock.edit', ['product' => $product, 'categories' => $categories, 'promos' => $promos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
        $product = $product->findOrFail($id);

        $request->validate([
            'price' => 'required|integer',
            'warranty' => 'required|integer|max:127',
            'in_stock' => 'required|integer|max:127',
            'status' => 'required|integer',
            'description' => 'required|string',
            'photos' => 'nullable',
            'photos.*' => 'image|max:2048',
            'active' => 'nullable|boolean',
            'discount_percent' => 'sometimes|required_with:discount_end_time|nullable|integer|max:100',
            'discount_cash' => 'sometimes|required_with:discount_end_time|nullable|integer',
            'discount_end_time' => 'required_with:discount_percent,discount_cash|nullable|date|after:today',
            'categories' => 'required',
            'categories.*' => 'integer',
            'details' => 'nullable',
            'details.*.name' => 'required_with:details|string|max:50',
            'details.*.value' => 'required_with:details|string|max:255',
            'newDetails' => 'nullable',
            'newDetails.*.name' => 'required_with:details|string|max:50',
            'newDetails.*.value' => 'required_with:details|string|max:255',
            'promos' => 'nullable|array',
            'promos.*' => 'required_with:promos|integer'
        ]);

        if (strtolower($product->name) != strtolower($request->name)) {
            $request->validate([
                'name' => 'required|unique:product|max:255'
            ]);
        } 

        $product->fill($request->except(['categories', 'details', 'newDetails', 'photos', 'active']));

        if (!empty($request->active)) {
            $product->active = 1;
        } else {
            $product->active = 0;
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $image = time() . "-" . $photo->getClientOriginalName();
                $photo->storeAs("public/product", $image);
                $product->photos()->save(new Photos(['name' => $image]));
            }
        }

        $product->categories()->sync($request->categories);

        if (!empty($request->promos)) {
            $product->promotion()->sync($request->promos);
        } else {
            $product->promotion()->detach();
        }

        if (!empty($request->details)) {
            foreach ($request->details as $key => $detail) {
                Details::findOrFail($key)->fill($detail)->save();
            }
        }

        if (!empty($request->newDetails)) {
            foreach ($request->newDetails as $newDetail) {
                $product->details()->save(new Details($newDetail));
            }
        }
        
        $check = $product->save();
        if ($check) {
            return back()->with('success', 'Sửa thành công');
        }
        return back()->with('fail', 'Sửa thất bại');
    }

    public function deletePhoto(Photos $photo, $id)
    {
        $photo = $photo->findOrFail($id);
        $photo_name = $photo->name;
        $check = $photo->delete();

        if ($check) {
            Storage::delete('public/product/'.$photo_name);
            return back()->with('success', 'Xóa ảnh thành công');
        }

        return back()->with('fail', 'Xóa ảnh thất bại');
    }

    public function deleteDetail(Details $detail, $id)
    {
        $detail = $detail->findOrFail($id);
        $check = $detail->delete();

        if ($check) {
            return back()->with('success', 'Xóa thông số kĩ thuật thành công');
        }
        return back()->with('fail', 'Xóa thông số kĩ thuật thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $product = $product->find($id);

        $product->categories()->detach();

        $product->promotion()->detach();

        $product->details()->delete();
        
        foreach ($product->photos as $photo) {
            Storage::delete('public/product/'.$photo->name);
        }
        $product->photos()->delete();

        $check = $product->delete();

        if ($check) {
            return response()->json([
                'status' => 'success'
            ]);
        }
        
        return response()->json([
            'status' => 'fail'
        ]);
    }

    public function destroyMany(Product $products, Request $request)
    {
        $products = $products->whereIn('id', $request->id);

        foreach ($products->get() as $product) {
            $product->categories()->detach();

            $product->promotion()->detach();

            $product->details()->delete();
            
            foreach ($product->photos as $photo) {
                Storage::delete('public/product/'.$photo->name);
            }
            $product->photos()->delete();
        }

        $check = $products->delete();

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
