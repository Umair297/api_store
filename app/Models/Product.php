<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'status',
        'category_id'
    ];
  protected $dates = ['deleted_at'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

public function cart()
{
    return $this->hasMany(Cart::class);
}

}
