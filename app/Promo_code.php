<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo_code extends Model
{
    protected $table = 'promo_code';
    protected $fillable = ['active_code', 'discount_percent', 'discount_cash', 'end_time', 'quantity', 'active'];
}
