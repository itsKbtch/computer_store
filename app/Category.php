<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name', 'parent_id', 'active'];

    function subCategories() {
    	return $this->hasMany('App\Category', 'parent_id');
    }

    function parentCategory() {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    function products() {
        return $this->belongsToMany('App\Product', 'category_product');
    }
}
