<?php

namespace App\Models;

use App\Models\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerViolation extends Model
{
    use HasFactory, UserTrait;
    protected $fillable = [
        'user_id',
        'violation_id',
        'count',
        'cant_edit_at'
    ];
    function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
