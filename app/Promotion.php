<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	protected $table = 'promotion';
    protected $fillable = ['name', 'content', 'end_time', 'active'];

    function products() {
    	return $this->belongsToMany('App\Product', 'apply_promo', 'promo_id', 'product_id');
    }
}
