<?php

namespace App\Models;

use App\Models\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory,UserTrait;
    protected $fillable = ['user_id', 'title'];

    public function violations()
    {
        return $this->hasMany(UnitViolation::class);
    }

    function unitOfficer()
    {
        return $this->hasOne(UnitOfficer::class)->whereExpiresAt(null);
    }
}
