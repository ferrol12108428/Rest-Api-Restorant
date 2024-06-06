<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [
        'id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'prodcut_category_id', 'id');
    }
}
