<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'specialization',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }
    public function visits()
    {
        return $this->hasMany(\App\Models\visit::class, 'doctor_id');
    }
}
