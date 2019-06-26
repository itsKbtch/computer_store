<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    function product() {
    	return $this->belongsTo('App\Product');
    }
}
