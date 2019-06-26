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
	Route::get("home", "\App\Http\Controllers\Admin\HomeController@index")->name('home.index');

	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('login');
	Route::post('/login','Auth\AdminLoginController@Login')->name('login.submit');
	//Route::get('/', 'AdminController@index')->name('admin.dashboard');	

	Route::prefix('stock')->name('stock.')->group(function() {
		Route::get("", "\App\Http\Controllers\Admin\StockController@index")->name('index');
		Route::get("create", "\App\Http\Controllers\Admin\StockController@create")->name('create');
		Route::post("create", "\App\Http\Controllers\Admin\StockController@store")->name('store');
		Route::get("{id}/details", "\App\Http\Controllers\Admin\StockController@show")->name('details');
		Route::get("{id}/edit", "\App\Http\Controllers\Admin\StockController@edit")->name('edit');
		Route::post("{id}/edit", "\App\Http\Controllers\Admin\StockController@update")->name('update');
		Route::get("detail/{id}/delete", "\App\Http\Controllers\Admin\StockController@deleteDetail")->name('detail.delete');
		Route::get("photo/{id}/delete", "\App\Http\Controllers\Admin\StockController@deletePhoto")->name('photo.delete');
		Route::get("{id}/delete", "\App\Http\Controllers\Admin\StockController@destroy")->name('delete');
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
});
Auth::routes();



