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
        // $now = Carbon::now();
        $now = Carbon::now();
        $dayOfWeek = $now->dayOfWeek;

        // Horários de funcionamento
        $weekdaysStart = Carbon::createFromTime(9, 0, 0);
        $weekdaysEnd = Carbon::createFromTime(17, 0, 0);
        $fridayStart = Carbon::createFromTime(8, 0, 0);
        $fridayEnd = Carbon::createFromTime(12, 0, 0);

        // Verificar se é fim de semana
        if ($dayOfWeek == Carbon::SATURDAY || $dayOfWeek == Carbon::SUNDAY) {
            return response()->view('errors.closed', [], 403); // Página de erro ou manutenção
        }

        // Verificar se é sexta-feira
        if ($dayOfWeek == Carbon::FRIDAY) {
            if ($now->lt($fridayStart) || $now->gt($fridayEnd)) {
                return response()->view('errors.closed', [], 403); // Página de erro ou manutenção
            }
        } else { // Segunda a quinta
            if ($now->lt($weekdaysStart) || $now->gt($weekdaysEnd)) {
                return response()->view('errors.closed', [], 403); // Página de erro ou manutenção
            }
        }

        return $next($request);
    }
}
