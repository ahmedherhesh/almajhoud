<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitViolation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'unit_id',
        'violation_id',
        'count'
    ];
}