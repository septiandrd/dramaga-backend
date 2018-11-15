<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'ordered_at',
        'paid_at',
        'cancelled_at',
        'sent_at',
        'arrived_at',
        'confirmed_at'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
