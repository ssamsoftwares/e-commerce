<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category',
        'slug',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->select('category');
    }

    public function product()
{
    return $this->hasMany(Product::class, 'subcategory');
}


}
