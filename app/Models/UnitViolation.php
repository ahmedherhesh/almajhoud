<?php

namespace App\Models;

use App\Models\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitViolation extends Model
{
    use HasFactory, UserTrait;
    protected $fillable = [
        'user_id',
        'unit_id',
        'violation_id',
        'count',
        'cant_edit_at'
    ];

    function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
