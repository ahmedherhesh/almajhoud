<?php

namespace App\Models;

use App\Models\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UnitOfficer extends Model
{
    use HasFactory, UserTrait;
    protected $fillable = ['user_id', 'unit_id', 'expires_at'];
    function scopeOfficer($query, Request $request)
    {
        return $query->whereUnitId($request->unit_id)->whereUserId($request->user_id)->whereExpiresAt(null);
    }
    function myUnit()
    {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }
}
