<?php

namespace App\Http\Middleware;

use App\Traits\CustomResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    use CustomResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('sanctum')->user()->type == 0) { // admin = 1 superAdmin = 2
            return $this->custom_response(false, 'You are not authorized to view tasks', [], 401);
        }
        return $next($request);
    }
}
