<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureClerkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('products.index')->with('error', 'Debes iniciar sesión para acceder a esta sección.');
        }

        $user = Auth::user();
        $adminEmails = array_filter(array_map('trim', explode(',', env('CLERK_ADMIN_EMAILS', ''))));

        $isEmailAdmin = !empty($user->email) && in_array($user->email, $adminEmails);
        $isDbAdmin = (bool) ($user->is_admin ?? false);

        if ($isDbAdmin || $isEmailAdmin) {
            return $next($request);
        }

        return redirect()->route('products.index')->with('error', 'Acceso denegado: Solo los administradores pueden ingresar al panel de administración.');
    }
}
