<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = ['post_review_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function orderstatus()
    {
        return $this->hasOne(Status::class, 'id', 'status');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'medical_record_id', 'id');
    }

    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class, 'medical_record_id', 'id');
    }
}
