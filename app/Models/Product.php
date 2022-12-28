<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'id_category',
        'slug', 
        'name',
        'description',

        'meta_title',
        'meta_keyword',
        'meta_description',
        
        'selling_price',
        'original_price',
        'featured',
        'quantity',
        'image',
        'brand',
        'popular',
        'status'
    ];

    protected $with = ['category'];
    
    public function category(){
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }
}
