<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'order_detail_id', 'id');
    }
}
