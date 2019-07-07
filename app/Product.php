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

    function invoices() {
        return $this->belongsToMany('App\Invoice', 'invoice_items')->withPivot('quantity', 'discount_cash', 'discount_percent');
    }

    function withSales() {
        $sales = $this->join('invoice_items', 'product.id', '=', 'invoice_items.product_id')
                    ->join('invoice', 'invoice.id', '=', 'invoice_items.invoice_id')
                    ->selectRaw('product.id, sum(invoice_items.quantity) as sales')
                    ->where('product.active', 1)
                    ->where('invoice.status', 1)
                    ->groupBy('product.id')->orderBy('sales', 'desc');

        return $this->joinSub($sales, 'sales', function($join) {
            $join->on('product.id', '=', 'sales.id');
        });
    }
}
