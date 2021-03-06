<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Patient extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }
}
