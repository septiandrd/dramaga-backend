<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'timestamp',
        'quantity',
        'total',
        'status',
        'resi'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function timeline() {
        return $this->hasOne(Timeline::class);
    }
}
