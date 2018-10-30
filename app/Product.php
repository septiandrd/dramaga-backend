<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'original_price',
        'discounted_price',
        'stock','category',
        'store_id'
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }



}