<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ecommerce Elite') - Premium Store</title>
    
    <!-- Fuentes de Google: Outfit (Títulos) e Inter (Cuerpo) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Clerk JS SDK (via jsDelivr CDN – con Publishable Key para autenticación) -->
    @if(config('services.clerk.publishable_key'))
    <script
        async
        crossorigin="anonymous"
        data-clerk-publishable-key="{{ config('services.clerk.publishable_key') }}"
        src="https://cdn.jsdelivr.net/npm/@clerk/clerk-js@latest/dist/clerk.browser.js"
        type="text/javascript"
    ></script>
    @endif

    <!-- Estilos de Tailwind CSS compilados por Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js para interactividad sin recarga -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0b0f19;
            color: #f1f5f9;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        /* Desplazamiento suave */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white">

    <!-- =========================================================================
         Header Principal (Efecto Glassmorphism Dark Mode)
         ========================================================================= -->
    <header class="sticky top-0 z-50 w-full backdrop-blur-md bg-slate-950/70 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('products.index') }}" class="flex items-center gap-2 group">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-300">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white group-hover:text-indigo-400 transition-colors duration-200">
                            ECOMMERCE<span class="text-indigo-500 font-extrabold">ELITE</span>
                        </span>
                    </a>
                </div>

                <!-- Navegación Central -->
                <nav class="hidden md:flex space-x-8 text-sm font-medium">
                    <a href="{{ route('products.index') }}" class="text-slate-300 hover:text-white transition-colors duration-200">Catálogo</a>
                    <a href="{{ route('products.index') }}?category=tecnologia" class="text-slate-400 hover:text-white transition-colors duration-200">Tecnología</a>
                    <a href="{{ route('products.index') }}?category=moda-accesorios" class="text-slate-400 hover:text-white transition-colors duration-200">Moda</a>
                    @if(Auth::check() && (Auth::user()->is_admin || (env('CLERK_ADMIN_EMAILS') && in_array(Auth::user()->email, array_filter(array_map('trim', explode(',', env('CLERK_ADMIN_EMAILS'))))))))
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors duration-200 flex items-center gap-1 font-semibold">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Admin Panel
                    </a>
                    @endif
                </nav>

                <!-- Iconos de Acción Derecha -->
                <div class="flex items-center gap-4">
                    
                    <!-- Carrito Botón Interactividad -->
                    @php
                        $cartCount = 0;
                        $cart = session()->get('cart', []);
                        foreach ($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all duration-300 hover:bg-slate-800/80 group">
                        <svg class="h-5 w-5 text-slate-300 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-tr from-rose-500 to-red-600 text-white font-extrabold text-xs h-5 w-5 rounded-full flex items-center justify-center border border-slate-950 animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Controles de Autenticación de Clerk -->
                    @auth
                        <div id="clerk-user-button" class="h-9 w-9 rounded-xl border border-slate-850 overflow-hidden flex items-center justify-center bg-slate-900 hover:border-slate-800 transition-all duration-300">
                            <div class="animate-spin rounded-full h-4 w-4 border-2 border-indigo-500 border-t-transparent"></div>
                        </div>
                    @else
                        <button id="clerk-sign-in" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors duration-200 cursor-pointer">
                            Iniciar Sesión
                        </button>
                        <button id="clerk-sign-up" class="px-4 py-2 text-sm font-bold text-white bg-gradient-to-tr from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 rounded-xl shadow-md hover:shadow-indigo-500/20 transition-all duration-300 cursor-pointer hover:scale-[1.02] active:scale-[0.98]">
                            Registrarse
                        </button>
                    @endauth

                </div>
            </div>
        </div>
    </header>

    <!-- =========================================================================
         Mensajes Flash de Notificaciones / Alertas Flotantes (AlpineJS)
         ========================================================================= -->
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 max-w-sm">
        @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-950/90 border border-emerald-800 text-emerald-300 p-4 rounded-xl shadow-2xl backdrop-blur-md">
                <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 bg-rose-950/90 border border-rose-800 text-rose-300 p-4 rounded-xl shadow-2xl backdrop-blur-md">
                <svg class="w-6 h-6 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         Contenido Principal Dinámico
         ========================================================================= -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- =========================================================================
         Pie de Página (Footer)
         ========================================================================= -->
    <footer class="bg-slate-950 border-t border-slate-900 py-12 mt-16 text-slate-500 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <div class="h-6 w-6 rounded bg-indigo-500 flex items-center justify-center">
                    <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-white font-bold tracking-tight text-base">
                    ECOMMERCE<span class="text-indigo-500 font-extrabold">ELITE</span>
                </span>
            </div>
            <p>&copy; 2026 Ecommerce Elite. Diseñado con un stack de alta disponibilidad Docker en Debian/Ubuntu.</p>
            <div class="flex gap-4">
                    @if(Auth::check() && (Auth::user()->is_admin || (env('CLERK_ADMIN_EMAILS') && in_array(Auth::user()->email, array_filter(array_map('trim', explode(',', env('CLERK_ADMIN_EMAILS'))))))))
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors duration-200">Panel Admin</a>
                    <span class="text-slate-800">|</span>
                    @endif
                    <span class="text-indigo-400 font-semibold flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 inline-block animate-ping"></span>
                        Entorno Alta Disponibilidad
                    </span>
                </div>
        </div>
    </footer>

    <!-- Inicialización de Clerk y Sincronización del Estado de Autenticación -->
    <script>
        // Esperar a que el SDK de Clerk esté disponible (el script se carga con async)
        function waitForClerk(maxWaitMs = 10000) {
            return new Promise((resolve, reject) => {
                if (window.Clerk) return resolve(window.Clerk);
                const start = Date.now();
                const interval = setInterval(() => {
                    if (window.Clerk) {
                        clearInterval(interval);
                        resolve(window.Clerk);
                    } else if (Date.now() - start > maxWaitMs) {
                        clearInterval(interval);
                        reject(new Error('Clerk SDK timeout'));
                    }
                }, 100);
            });
        }

        // Fallback: si Clerk no carga, mostrar error en los botones
        function enableFallbackButtons() {
            const signInBtn = document.getElementById('clerk-sign-in');
            const signUpBtn = document.getElementById('clerk-sign-up');
            if (signInBtn) {
                signInBtn.title = 'Error al cargar el sistema de autenticación. Revisa la consola.';
                signInBtn.style.opacity = '0.5';
                signInBtn.style.cursor = 'not-allowed';
            }
            if (signUpBtn) {
                signUpBtn.title = 'Error al cargar el sistema de autenticación. Revisa la consola.';
                signUpBtn.style.opacity = '0.5';
                signUpBtn.style.cursor = 'not-allowed';
            }
        }

        window.addEventListener('load', async () => {
            const publishableKey = "{{ config('services.clerk.publishable_key') }}";
            
            if (!publishableKey) {
                console.warn('[Clerk] VITE_CLERK_PUBLISHABLE_KEY no está configurada en el .env');
                enableFallbackButtons();
                return;
            }

            console.log('[Clerk] Iniciando con key:', publishableKey.substring(0, 20) + '...');

            try {
                const clerk = await waitForClerk();
                console.log('[Clerk] SDK cargado, inicializando...');

                await clerk.load({
                    afterSignInUrl: '/',
                    afterSignUpUrl: '/',
                });

                console.log('[Clerk] Inicializado. Usuario:', clerk.user ? clerk.user.primaryEmailAddress?.emailAddress : 'no autenticado');

                if (clerk.user && clerk.session) {
                    // Sincronizar el token con las cookies para que Laravel lo reciba
                    try {
                        const token = await clerk.session.getToken();
                        document.cookie = `__session=${token}; path=/; max-age=3600; SameSite=Lax`;
                    } catch (e) {
                        console.error('[Clerk] Error obteniendo token:', e);
                    }

                    // Usuario autenticado en Clerk
                    const userBtn = document.getElementById('clerk-user-button');

                    if (userBtn) {
                        // Backend ya sabe del usuario → solo actualizar el avatar
                        const imgUrl = clerk.user.imageUrl;
                        userBtn.innerHTML = `
                            <img src="${imgUrl}" alt="Avatar" class="h-9 w-9 rounded-xl object-cover cursor-pointer" title="Cerrar sesión" />
                        `;
                        userBtn.style.cursor = 'pointer';
                        userBtn.addEventListener('click', () => {
                            if (confirm('¿Deseas cerrar sesión?')) {
                                document.cookie = '__session=; path=/; max-age=0; SameSite=Lax';
                                clerk.signOut().then(() => window.location.reload());
                            }
                        });
                    } else {
                        // Desincronización: Clerk dice autenticado pero Laravel no.
                        // Reemplazamos los botones de sign-in/sign-up por el avatar en el DOM.
                        const signInBtn = document.getElementById('clerk-sign-in');
                        const signUpBtn = document.getElementById('clerk-sign-up');
                        const container = signInBtn?.parentElement ?? signUpBtn?.parentElement;

                        if (container) {
                            // Ocultar botones de login/registro
                            if (signInBtn) signInBtn.style.display = 'none';
                            if (signUpBtn) signUpBtn.style.display = 'none';

                            // Insertar avatar inline
                            const avatarEl = document.createElement('div');
                            avatarEl.id = 'clerk-user-button-inline';
                            avatarEl.className = 'h-9 w-9 rounded-xl border border-slate-700 overflow-hidden flex items-center justify-center cursor-pointer hover:border-indigo-500 transition-all duration-300';
                            avatarEl.title = 'Cerrar sesión';
                            avatarEl.innerHTML = `<img src="${clerk.user.imageUrl}" alt="Avatar" class="h-9 w-9 object-cover" />`;
                            avatarEl.addEventListener('click', () => {
                                if (confirm('¿Deseas cerrar sesión?')) {
                                    document.cookie = '__session=; path=/; max-age=0; SameSite=Lax';
                                    clerk.signOut().then(() => window.location.reload());
                                }
                            });
                            container.appendChild(avatarEl);
                        }
                    }
                } else {
                    // Asegurar que no quede un token viejo
                    document.cookie = '__session=; path=/; max-age=0; SameSite=Lax';
                    
                    // No autenticado en Clerk → conectar botones de inicio de sesión / registro
                    const signInBtn = document.getElementById('clerk-sign-in');
                    if (signInBtn) {
                        signInBtn.addEventListener('click', () => {
                            console.log('[Clerk] Redirigiendo a Sign In...');
                            clerk.redirectToSignIn({ afterSignInUrl: window.location.href });
                        });
                    }

                    const signUpBtn = document.getElementById('clerk-sign-up');
                    if (signUpBtn) {
                        signUpBtn.addEventListener('click', () => {
                            console.log('[Clerk] Redirigiendo a Sign Up...');
                            clerk.redirectToSignUp({ afterSignUpUrl: window.location.href });
                        });
                    }
                }

                // Sincronización de sesión backend↔frontend (una sola recarga para evitar loops)
                const backendLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                const frontendLoggedIn = !!clerk.session;
                const reloadKey = 'clerk_sync_reload';

                if (backendLoggedIn !== frontendLoggedIn && !sessionStorage.getItem(reloadKey)) {
                    console.log(`[Clerk] Desincronización: backend=${backendLoggedIn}, frontend=${frontendLoggedIn}. Recargando...`);
                    sessionStorage.setItem(reloadKey, '1');
                    window.location.reload();
                } else {
                    sessionStorage.removeItem(reloadKey);
                }

            } catch (err) {
                console.error('[Clerk] Error al inicializar:', err.message);
                enableFallbackButtons();
            }
        });
    </script>

</body>
</html>
