<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{   
    protected $table = 'transaction_has_categories';
    public $timestamps = false;

    protected $guarded = [];

    public function category(){
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
