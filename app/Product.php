<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'original_price',
        'discounted_price',
        'stock','category',
        'store_id'
    ];

    protected $dates = ['deleted_at'];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

}