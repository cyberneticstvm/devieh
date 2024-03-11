<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function frombranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch', 'id');
    }

    public function tobranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch', 'id');
    }

    public function details()
    {
        return $this->hasMany(TransferDetail::class, 'transfer_id', 'id');
    }
}
