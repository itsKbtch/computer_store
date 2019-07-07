<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $fillable = ['name', 'phone_number', 'email', 'address', 'user_id', 'total', 'discount_percent', 'discount_cash', 'total_with_discount', 'status'];

    public function items() {
    	return $this->belongsToMany('App\Product', 'invoice_items')->withPivot('quantity', 'discount_cash', 'discount_percent');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
