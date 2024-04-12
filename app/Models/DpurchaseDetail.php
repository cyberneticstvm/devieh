<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DpurchaseDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = ['expiry_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function product()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
