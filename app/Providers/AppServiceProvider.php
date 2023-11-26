<?php

namespace App\Providers;

use App\Models\Unit;
use App\Models\UnitViolation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $user = auth('sanctum')->user();
        if ($user) {
            Unit::created(function ($unit) use ($user) {
                $unit->update(['user_id' => $user->id,]);
            });
            UnitViolation::created(function ($unitVaiolation) use ($user) {
                $unitVaiolation->update([
                    'user_id' => $user->id,
                    'cant_edit_at' => Carbon::now()->addMinutes(10)
                ]);
            });
            User::created(function ($user) {
                $user->assignRole('user');
            });
        }
    }
}
