<?php

namespace App\Models;

use App\Models\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory,UserTrait;
    protected $fillable = ['user_id','title'];

    function unitViolation(){
        return $this->hasMany(UnitViolation::class);
    }
}
