<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->route('user_id');

        if (!Auth::check()) {
            return redirect('/home')->withErrors(['error' => 'Acesso não autorizado.']);
        }

        if (Auth::check() && $userId == Auth::id()) {
            return $next($request);
        }

        $user = User::with('pessoa')->find(Auth::user()->id);

        // Verifica o nível de acesso usando Gates definidos
        if (Gate::allows('is_admin')) {
            return $next($request);
        }

        if (Gate::allows('is_encpes')) {
            return $next($request);
        }
        // dd(User::with('pessoa')->find($user));
        if (Gate::allows('is_sgtte')) {
            $requestedUser = User::with('pessoa')->find($request->id);
            if (!$requestedUser || $requestedUser->pessoa->secao_id !== $user->pessoa->secao_id) {
                return redirect('/home')->withErrors(['error' => 'Acesso não autorizado.']);
            }
            return $next($request);
        }

        if (Gate::allows('is_cmt') || Gate::allows('is_chsec')) {
            $requestedUser = User::with('pessoa')->find($request->id);
            // Verifica se o usuário requisitado não é o próprio usuário logado
            if ($request->id !== $user->id) {
                // Se for 'is_chsec', verifica se os 'secao_id' são diferentes
                if (Gate::allows('is_chsec') && $requestedUser->pessoa->secao_id !== $user->pessoa->secao_id) {
                    return redirect('/home')->withErrors(['error' => 'Acesso não autorizado.']);
                }
            }
            return $next($request);
        }
        

        if (Gate::allows('is_usuario') && $request->id == Auth::id()) {
            return $next($request);
            // return redirect('/home')->withErrors(['error' => 'Acesso não autorizado.']);
        }

        return redirect('/home')->withErrors(['error' => 'Acesso não autorizado.']);
    }
}
