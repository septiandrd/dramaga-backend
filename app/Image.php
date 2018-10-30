<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'link',
        'product_id'
    ];

    public function user() {
        return $this->belongsTo(Product::class);
    }
}