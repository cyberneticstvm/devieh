<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = ['created_at' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function invoice($oid)
    {
        return ($this->invoice) ? "<a href='/admin/pdf/invoice/" . $oid . "' target='_blank'>" . $this->invoice . "</a>" : "<a href='/admin/helper/generate/invoice/$oid' class='proceed'>Invoice</a>";
    }

    public function mrecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id', 'id');
    }

    public function orderstatus()
    {
        return $this->hasOne(Status::class, 'id', 'order_status');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function padvisor()
    {
        return $this->hasOne(User::class, 'id', 'product_advisor');
    }
}
