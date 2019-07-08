<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shop_info';
    protected $fillable = ['phone_number', 'email', 'address', 'facebook', 'open_time', 'about'];
}
