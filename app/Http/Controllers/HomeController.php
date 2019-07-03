<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Slideshow;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'myAccount']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with(['subCategories', 'products' => function($query) {
            $query->with('photos')->where('active', 1)->limit(15);
        }])->whereNull('parent_id')->where('active', 1)->get();

        $slideshow = Slideshow::all();

        $promoProducts = Product::whereNotNull('discount_end_time')->orHas('promotion')->get();

        return view('home.index', ['categories' => $categories, 'promoProducts' => $promoProducts, 'slideshow' => $slideshow]);
    }

    public function details(Product $product, $slug) {
        $categories = Category::with(['subCategories'])->whereNull('parent_id')->where('active', 1)->get();

        $slideshow = Slideshow::all();

        $slug = explode('-', $slug);

        $id = end($slug);

        $product = $product->with(['photos', 'promotion', 'details', 'categories'])->findOrFail($id);

        $relates = $product->categories->map(function ($item, $key) {
            return $item->id;
        });

        $related = new Product;

        $related = $related->whereHas('categories', function($query) use ($relates) {
            $query->whereIn('category_id', $relates);
        });

        // foreach ($relates as $category) {
        //     $related = $related->whereHas('categories', function($query) use ($category) {
        //         $query->where('category_id', $category);
        //     });
        // }

        $related = $related->distinct()->where('active', 1)->where('id', '!=', $id)->limit(15)->get();

        return view('home.details', ['categories' => $categories, 'product' => $product, 'relates' => $related, 'slideshow' => $slideshow]);
    }

    public function category($category, $sub_category = NULL) {
        $categories = Category::with(['subCategories'])->whereNull('parent_id')->where('active', 1)->get();

        $slideshow = Slideshow::all();

        $category = explode('-', $category);

        $category = end($category);

        $id = $category;

        if (!empty($sub_category)) {
            $sub_category = explode('-', $sub_category);

            $sub_category = end($sub_category);

            $id = $sub_category;
        }

        $products = new Product;
        
        $products = $products->whereHas('categories', function($query) use ($id) {
            $query->where('id', $id);
        });

        if (isset($_GET['filters'])) {
            $products = $products->where(function($query) {
                foreach ($_GET['filters'] as $filter) {
                    if ($filter == 'discount') {
                        $query->whereNotNull('discount_end_time');
                    };
                    if ($filter == 'promotion') {
                        $query->orHas('promotion');
                    };
                }
            });
        }

        if (isset($_GET['price'])) {
            if ($_GET['price'] == 'lower1') {
                $products = $products->where('price', '<', 1000000);
            }
            if ($_GET['price'] == 'from1to2') {
                $products = $products->whereBetween('price', [1000000, 2000000]);
            }
            if ($_GET['price'] == 'from2to5') {
                $products = $products->whereBetween('price', [2000000, 5000000]);
            }
            if ($_GET['price'] == 'from5to10') {
                $products = $products->whereBetween('price', [5000000, 10000000]);
            }
            if ($_GET['price'] == 'greater10') {
                $products = $products->where('price', '>', 10000000);
            }
        }

        $products = $products->where('active', 1);

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'gia-cao-den-thap') {
                $products = $products->orderBy('price', 'desc');
            }
            if ($_GET['sort'] == 'gia-thap-den-cao') {
                $products = $products->orderBy('price', 'asc');
            }
        } else {
            $products = $products->orderBy('price', 'desc');
        }

        $products = $products->paginate(15)->appends($_GET);

        $mainCategory = $categories->find($category);

        $subCategory = $mainCategory->subCategories->find($sub_category);

        return view('home.category', [
            'categories' => $categories, 
            'products' => $products, 
            'mainCategory' => $mainCategory, 
            'subCategory' => $subCategory, 
            'slideshow' => $slideshow
        ]);
    }

    public function search() {
        $categories = Category::with(['subCategories'])->whereNull('parent_id')->where('active', 1)->get();

        $slideshow = Slideshow::all();

        $products = new Product;

        if (isset($_GET['category'])) {
            $products = $products->whereHas('categories', function($query) {
                $query->whereIn('category_id', $_GET['category']);
            });
        }

        if (isset($_GET['filters'])) {
            $products = $products->where(function($query) {
                foreach ($_GET['filters'] as $filter) {
                    if ($filter == 'discount') {
                        $query->whereNotNull('discount_end_time');
                    };
                    if ($filter == 'promotion') {
                        $query->orHas('promotion');
                    };
                }
            });
        }

        if (isset($_GET['keyword'])) {
            $products = $products->where('name', 'like', '%'.$_GET['keyword'].'%');
        }

        if (isset($_GET['price'])) {
            if ($_GET['price'] == 'lower1') {
                $products = $products->where('price', '<', 1000000);
            }
            if ($_GET['price'] == 'from1to2') {
                $products = $products->whereBetween('price', [1000000, 2000000]);
            }
            if ($_GET['price'] == 'from2to5') {
                $products = $products->whereBetween('price', [2000000, 5000000]);
            }
            if ($_GET['price'] == 'from5to10') {
                $products = $products->whereBetween('price', [5000000, 10000000]);
            }
            if ($_GET['price'] == 'greater10') {
                $products = $products->where('price', '>', 10000000);
            }
        }

        if (isset($_GET['sort'])) {
            if ($_GET['sort'] == 'gia-cao-den-thap') {
                $products = $products->orderBy('price', 'desc');
            }
            if ($_GET['sort'] == 'gia-thap-den-cao') {
                $products = $products->orderBy('price', 'asc');
            }
        } else {
            $products = $products->orderBy('price', 'desc');
        }

        $products = $products->where('active', 1)->paginate(15)->appends($_GET);

        return view('home.search', [
            'categories' => $categories, 
            'products' => $products, 
            'slideshow' => $slideshow
        ]);
    }
}
