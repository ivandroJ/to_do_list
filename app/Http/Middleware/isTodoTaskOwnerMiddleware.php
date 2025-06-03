<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class isTodoTaskOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todoTaskId = $request->route('id');

        Log::info('Checking ownership for todo task ID: ' . $todoTaskId);

        if(Auth::user()->todoTasks->where('id', $todoTaskId)->count() === 0) {
            return response()->json(['message' => 'You are not the owner of this todo task'], 403);
        }

        return $next($request);
    }
}
