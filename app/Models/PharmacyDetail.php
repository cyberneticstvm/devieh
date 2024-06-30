<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['expiry_date' => 'datetime'];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'order_detail_id', 'id');
    }
}
