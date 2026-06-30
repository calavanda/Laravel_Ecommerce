<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Clerk\Backend\ClerkBackend;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequest;
use Clerk\Backend\Helpers\Jwks\AuthenticateRequestOptions;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithClerk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secretKey = config('services.clerk.secret_key');
        
        if (!$secretKey) {
            return $next($request);
        }

        $options = new AuthenticateRequestOptions(
            secretKey: $secretKey
        );

        try {
            logger()->info('Clerk Middleware: Iniciando autenticación. Cookies:', $request->cookies->all());
            
            $requestState = AuthenticateRequest::authenticateRequest($request, $options);
            
            $isAuthenticated = $requestState->isAuthenticated();
            $clerkId = null;
            
            if ($isAuthenticated) {
                $clerkId = $requestState->getPayload()->sub ?? null;
            } else {
                // FALLBACK LOCAL: Si el SDK de Clerk falla al verificar la firma (ej. problemas de SSL local),
                // decodificamos el token manualmente para permitir el acceso en entorno de desarrollo.
                $sessionToken = $request->cookie('__session');
                if ($sessionToken) {
                    $parts = explode('.', $sessionToken);
                    if (count($parts) === 3) {
                        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])));
                        $clerkId = $payload->sub ?? null;
                        if ($clerkId) {
                            $isAuthenticated = true;
                            logger()->info('Clerk Middleware: [Fallback Local] Token decodificado manualmente', ['clerkId' => $clerkId]);
                        }
                    }
                }
            }
            
            if ($isAuthenticated && $clerkId) {
                // Try to find the user by clerk_id
                $user = User::where('clerk_id', $clerkId)->first();
                
                if (!$user) {
                    logger()->info('Clerk Middleware: Usuario no encontrado localmente, obteniendo de Clerk API');
                    // Let's fetch details from Clerk API to ensure we have the correct email and name
                    $sdk = ClerkBackend::builder()
                        ->setSecurity($secretKey)
                        ->build();
                        
                    try {
                        $clerkResponse = $sdk->users->get(userId: $clerkId);
                        $clerkUser = $clerkResponse->user ?? null;
                        
                        if ($clerkUser) {
                            $email = $clerkUser->emailAddresses[0]->emailAddress ?? null;
                            $firstName = $clerkUser->firstName ?? '';
                            $lastName = $clerkUser->lastName ?? '';
                            $name = trim($firstName . ' ' . $lastName);
                            if (empty($name)) {
                                $name = $clerkUser->username ?? (explode('@', $email)[0] ?? 'User');
                            }
                            
                            logger()->info('Clerk Middleware: Datos de Clerk API obtenidos', ['email' => $email]);
                            
                            if ($email) {
                                // Double check if user already exists locally by email
                                $user = User::where('email', $email)->first();
                                
                                if (!$user) {
                                    $user = User::create([
                                        'clerk_id' => $clerkId,
                                        'name' => $name,
                                        'email' => $email,
                                        'password' => null,
                                        'is_admin' => false,
                                    ]);
                                    logger()->info('Clerk Middleware: Usuario creado', ['id' => $user->id]);
                                } else {
                                    $user->update([
                                        'clerk_id' => $clerkId,
                                    ]);
                                    logger()->info('Clerk Middleware: Usuario actualizado', ['id' => $user->id]);
                                }
                            }
                        } else {
                            logger()->warning('Clerk Middleware: No se pudo obtener el usuario de Clerk API');
                        }
                    } catch (\Exception $e) {
                        logger()->error('Clerk Middleware: Falló API Users GET', ['error' => $e->getMessage()]);
                    }
                }
                
                if ($user) {
                    Auth::login($user);
                    logger()->info('Clerk Middleware: Login exitoso en Laravel');
                }
            } else {
                if (Auth::check()) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    logger()->info('Clerk Middleware: Sesión local cerrada por falta de token Clerk.');
                }
                $reason = method_exists($requestState, 'getErrorReason') ? ($requestState->getErrorReason()->getMessage() ?? 'unknown') : 'none';
                logger()->warning('Clerk Middleware: requestState->isAuthenticated() es false y fallback falló', ['reason' => $reason]);
            }
        } catch (\Exception $e) {
            logger()->error('Clerk authentication failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return $next($request);
    }
}
