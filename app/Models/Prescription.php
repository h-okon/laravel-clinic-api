<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'patient_id',
        'doctor_id',
    ];


    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}
