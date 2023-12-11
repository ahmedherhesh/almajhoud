<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = auth('sanctum')->user();
        if ($user && in_array($permission, $user->getPermissionNames()->toArray()))
            return $next($request);
        return response()->json(['status' => 400, 'msg' => 'تم حظر الوصول لهذه الصفحة']);
    }
}
