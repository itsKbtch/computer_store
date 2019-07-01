<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = ['name', 'price', 'description', 'warranty', 'in_stock', 'status', 'rate', 'rate_count', 'discount_percent', 'discount_cash', 'discount_end_time', 'active'];

    function details() {
    	return $this->hasMany('App\Details');
    }

    function photos() {
    	return $this->hasMany('App\Photos');
    }

    function categories() {
    	return $this->belongsToMany('App\Category', 'category_product');
    }
    
    function promotion() {
    	return $this->belongsToMany('App\Promotion', 'apply_promo', 'product_id', 'promo_id');
    }
}
