<?php

namespace App\Providers;

use App\Models\OfficerViolation;
use App\Models\User;
use App\Models\Violation;
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
            OfficerViolation::created(function ($officerVaiolation) use ($user) {
                $officerVaiolation->update([
                    'user_id' => $user->id,
                    'cant_edit_at' => Carbon::now()->addMinutes(10)
                ]);
            });
            Violation::created(function ($violation) use ($user) {
                $violation->update(['user_id' => $user->id]);
            });
            User::created(function ($user) {
                $user->assignRole('user');
            });
        }
    }
}
