<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

class CheckTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        $closingTime = Carbon::createFromTime(8, 0, 0); // Horário de fechamento (17:00)

        if ($now->greaterThanOrEqualTo($closingTime)) {
            // return response()->view('errors.closed', [], 403); // Página de erro ou manutenção
        }

        return $next($request);
    }
}
