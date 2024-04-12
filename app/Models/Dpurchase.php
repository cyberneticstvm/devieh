<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dpurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = ['order_date' => 'datetime', 'delivery_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(DpurchaseDetail::class, 'purchase_id', 'id');
    }
}
