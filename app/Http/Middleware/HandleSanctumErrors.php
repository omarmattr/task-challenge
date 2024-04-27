<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HandleSanctumErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthenticationException $exception) {
            return $this->handleAuthenticationException($request, $exception);
        } catch (Throwable $exception) {
            return $this->handleOtherExceptions($request, $exception);
        }
    }

    protected function handleAuthenticationException(Request $request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated.',
            'error' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }

    protected function handleOtherExceptions(Request $request, Throwable $exception)
    {
        // Handle other exceptions here
        return response()->json([
            'message' => 'Internal server error.',
            'error' => $exception->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
