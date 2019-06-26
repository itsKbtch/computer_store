<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab = "", $parent_id = 0)
    {
        $categories = new Category;
        $filters = [];

        if (isset($_GET['filters'])) {
            foreach ($_GET['filters'] as $filter) {
                if ($filter == 'active') {
                    $categories = $categories->where('active', 1);
                };
                if ($filter == 'inactive') {
                    $categories = $categories->where('active', 0);
                };
                $filters['filters[]'] = $filter;
            }
        }

        if (isset($_GET['keyword'])) {
            $categories = $categories->where('name', 'like', '%'.$_GET['keyword'].'%');
            $filters['keyword'] = $_GET['keyword'];
        }
        
        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'old') {
                $categories = $categories->orderBy('created_at', 'asc');
            } else {
                $categories = $categories->orderBy('created_at', 'desc');
            };
            $filters['sort'] = $_GET['sort'];
        } else {
            $categories = $categories->orderBy('created_at', 'desc');
        }

        switch ($tab) {
            case '':
                $categories = $categories->paginate(5)->appends($filters);
                $response = ['categories' => $categories, 'tab' => $tab];
                break;

            case 'main':
                $categories = $categories->whereNull('parent_id');
                $categories = $categories->paginate(5)->appends($filters);
                $response = ['categories' => $categories, 'tab' => $tab];
                break;

            case 'sub':
                $mainCategories = Category::whereNull('parent_id')->get();
                if (!empty($parent_id)) {
                    $categories = $categories->find($parent_id)->subCategories();
                } else {
                    $categories = $categories->whereNotNull('parent_id');
                }
                $categories = $categories->paginate(5)->appends($filters);
                $response = ['categories' => $categories, 'tab' => $tab, 'mainCategories' => $mainCategories, 'parent_id' => $parent_id];
                break;

            default:
                $categories = $categories->paginate(5)->appends($filters);
                $response = ['categories' => $categories, 'tab' => $tab];
                break;
        }
        return view('admin.category.index', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('active', 1)->whereNull('parent_id')->get();

        return view('admin.category.create', ['categories' => $categories]);
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
            'name' => 'required|unique:category|max:50',
            'parent_id' => 'nullable|integer',
            'active' => 'nullable|boolean'
        ]);

        $category = new Category;

        $category->fill([
            'name' => $request->input('name'), 
            'parent_id' => ($request->input('parent_id') == 0)? NULL: $request->input('parent_id'),
            'active' => ($request->has('active'))? 1: 0
        ]);

        $check = $category->save();
        if ($check) {
            return redirect('admin/category')->with('success', 'Thêm mới thành công');
        }
        return redirect('admin/category/create')->with('fail', 'Thêm mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, $id)
    {
        $category = $category->findOrFail($id);

        return view('admin.category.details', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, $id)
    {
        $category = $category->findOrFail($id);
        $categories = Category::where('active', 1)->whereNull('parent_id')->where('id', '<>', $id)->get();

        return view('admin.category.edit', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, $id)
    {
        $category = $category->findOrFail($id);

        if (strtolower($category->name) == strtolower($request->name)) {
            $request->validate([
                'parent_id' => 'nullable|integer',
                'active' => 'nullable|boolean'
            ]);
        } else {
            $request->validate([
                'name' => 'required|unique:category|max:50',
                'parent_id' => 'nullable|integer',
                'active' => 'nullable|boolean'
            ]);
        }

        $category->fill([
            'name' => $request->input('name'), 
            'parent_id' => ($request->input('parent_id') == 0)? NULL: $request->input('parent_id'),
            'active' => ($request->has('active'))? 1: 0
        ]);

        $check = $category->save();

        if ($check) {
            return redirect('admin/category/'.$id.'/edit')->with('success', 'Chỉnh sửa thành công');
        }
        return redirect('admin/category/'.$id.'/edit')->with('fail', 'Chỉnh sửa thất bại');
    }

    public function removeParent(Category $category, $id, $sub_id)
    {
        $category = $category->findOrFail($sub_id);

        $category->parent_id = NULL;

        $check = $category->save();

        if ($check) {
            return redirect('admin/category/'.$id.'/edit')->with('success', 'Xóa danh mục con thành công');
        }
        return redirect('admin/category/'.$id.'/edit')->with('fail', 'Xóa danh mục con thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $category = $category->findOrFail($id);

        if ($category->subCategories->isEmpty()) {
            $category->products()->detach();

            if($category->delete()) {
                return response()->json([
                    'status' => 'success'
                ]);
            }
        }

        return response()->json([
            'status' => 'error'
        ]); 
    }

    public function destroyMany(Category $categories, Request $request)
    {
        $categories = $categories->whereIn('id', $request->id);

        $check = true;
        foreach ($categories->get() as $category) {
            if (!$category->subCategories->isEmpty()) {
                $check = false;
                break;
            }
        }

        if ($check) {
            foreach ($categories as $category) {
                $category->products()->detach();
            }
    
            if($categories->delete()) {
                return response()->json([
                    'status' => 'success'
                ]);
            }

            return response()->json([
                'status' => 'fail'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
