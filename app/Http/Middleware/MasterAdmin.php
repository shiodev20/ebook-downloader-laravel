<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasterAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(session('currentUser')['role'] === RoleEnum::MASTER_ADMIN->value);
        
        if(session('currentUser')['role'] === RoleEnum::MASTER_ADMIN->value) return $next($request);
        else return response()->view('errors.403', [], 403);
    }
}
