<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'value', 'product_id'];
}
