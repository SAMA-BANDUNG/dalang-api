<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function photos() {
        return $this->hasMany(ProductPhotos::class, 'product_id', 'id');
    }
}
