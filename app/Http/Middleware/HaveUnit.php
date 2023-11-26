<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HaveUnit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('sanctum')->user();
        //if user is not admin
        if ($user && !$user->hasRole('admin')) {
            //if the user have any unit
            if (!$user->unit)
                return response()->json(['msg' => 'عفوا انت لا تملك الصلاحية للوصول لأي وحدة مرور']);
            //if user cant access to this unit
            if ($user->unit->id != $request->unit_id)
                return response()->json(['msg' => 'لا تملك صلاحية الوصول لهذه الوحدة']);
        }
        return $next($request);
    }
}
