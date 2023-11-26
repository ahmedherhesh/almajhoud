<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title'];
    public function violations(){
        return $this->hasMany(UnitViolation::class);
    }
}
