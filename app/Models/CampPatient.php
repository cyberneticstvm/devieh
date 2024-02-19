<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampPatient extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['registration_date' => 'date'];

    public function camp()
    {
        return $this->belongsTo(Camp::class, 'camp_id', 'id');
    }
}
