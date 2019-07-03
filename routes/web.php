<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function() {
	
	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('login');
	Route::post('/login','Auth\AdminLoginController@Login')->name('login.submit');
	// Route::get('/', 'AdminController@index')->name('dashboard');	
	Route::get("/home", "\App\Http\Controllers\Admin\HomeController@index")->name('home.index');


	Route::prefix('stock')->name('stock.')->group(function() {
		Route::get("", "\App\Http\Controllers\Admin\StockController@index")->name('index');
		Route::get("create", "\App\Http\Controllers\Admin\StockController@create")->name('create');
		Route::post("create", "\App\Http\Controllers\Admin\StockController@store")->name('store');
		Route::get("{id}/details", "\App\Http\Controllers\Admin\StockController@show")->name('details');
		Route::get("{id}/edit", "\App\Http\Controllers\Admin\StockController@edit")->name('edit');
		Route::post("{id}/edit", "\App\Http\Controllers\Admin\StockController@update")->name('update');
		Route::get("detail/{id}/delete", "\App\Http\Controllers\Admin\StockController@deleteDetail")->name('detail.delete');
		Route::get("photo/{id}/delete", "\App\Http\Controllers\Admin\StockController@deletePhoto")->name('photo.delete');
		Route::delete("{id}/delete", "\App\Http\Controllers\Admin\StockController@destroy")->name('delete');
		Route::post("/deleteMany", "\App\Http\Controllers\Admin\StockController@destroyMany")->name('deleteMany');
	});
	
	Route::prefix('category')->name('category.')->group(function() {
		Route::get("", "\App\Http\Controllers\Admin\CategoryController@index")->name('index');
		Route::get("/tab/{tab?}/{parent_id?}", "\App\Http\Controllers\Admin\CategoryController@index")->name('index.tab');
		Route::get("{id}/details", "\App\Http\Controllers\Admin\CategoryController@show")->name('details');
		Route::get("{id}/edit", "\App\Http\Controllers\Admin\CategoryController@edit")->name('edit');
		Route::post("{id}/edit", "\App\Http\Controllers\Admin\CategoryController@update")->name('update');
		Route::get("{id}/edit/removeSub/{sub_id}", "\App\Http\Controllers\Admin\CategoryController@removeParent")->name('update.removeSub');
		Route::get("create", "\App\Http\Controllers\Admin\CategoryController@create")->name('create');
		Route::post("create", "\App\Http\Controllers\Admin\CategoryController@store")->name('store');
		Route::delete("{id}/delete", "\App\Http\Controllers\Admin\CategoryController@destroy")->name('delete');
		Route::post("/deleteMany", "\App\Http\Controllers\Admin\CategoryController@destroyMany")->name('deleteMany');
	});

	Route::prefix('promo')->name('promo.')->group(function() {
		Route::get("", "\App\Http\Controllers\Admin\PromoController@index")->name('index');
		Route::get("{id}/details", "\App\Http\Controllers\Admin\PromoController@show")->name('details');
		Route::get("{id}/edit", "\App\Http\Controllers\Admin\PromoController@edit")->name('edit');
		Route::post("{id}/edit", "\App\Http\Controllers\Admin\PromoController@update")->name('update');
		Route::get("{id}/edit/unapply/{product_id}", "\App\Http\Controllers\Admin\PromoController@unapply")->name('update.unapply');
		Route::get("create", "\App\Http\Controllers\Admin\PromoController@create")->name('create');
		Route::post("create", "\App\Http\Controllers\Admin\PromoController@store")->name('store');
		Route::get("{id}/apply", "\App\Http\Controllers\Admin\PromoController@apply_show")->name('apply.show');
		Route::post("{id}/apply", "\App\Http\Controllers\Admin\PromoController@apply")->name('apply');
		Route::delete("{id}/delete", "\App\Http\Controllers\Admin\PromoController@destroy")->name('delete');
		Route::post("deleteMany", "\App\Http\Controllers\Admin\PromoController@destroyMany")->name('deleteMany');
	});

	Route::prefix('code')->name('code.')->group(function() {
		Route::get("", "\App\Http\Controllers\Admin\CodeController@index")->name('index');
		Route::get("{id}/details", "\App\Http\Controllers\Admin\CodeController@show")->name('details');
		Route::get("{id}/edit", "\App\Http\Controllers\Admin\CodeController@edit")->name('edit');
		Route::post("{id}/edit", "\App\Http\Controllers\Admin\CodeController@update")->name('update');
		Route::get("create", "\App\Http\Controllers\Admin\CodeController@create")->name('create');
		Route::post("create", "\App\Http\Controllers\Admin\CodeController@store")->name('store');
		Route::delete("{id}/delete", "\App\Http\Controllers\Admin\CodeController@destroy")->name('delete');
		Route::post("deleteMany", "\App\Http\Controllers\Admin\CodeController@destroyMany")->name('deleteMany');
	});
});
Auth::routes();




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
