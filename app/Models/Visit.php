<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "date",
        "doctor_id",
        "user_id"
    ];
}
