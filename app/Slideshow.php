<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $table = 'slideshow';
    protected $fillable = ['photo', 'caption', 'link', 'active'];
}
