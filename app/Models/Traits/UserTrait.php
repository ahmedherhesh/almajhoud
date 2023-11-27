<?php

namespace App\Models\Traits;

use App\Models\User;

trait UserTrait
{
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
