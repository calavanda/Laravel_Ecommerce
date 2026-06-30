<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Ecommerce Elite</title>
    
    <!-- Fuentes de Google: Outfit (Títulos) e Inter (Cuerpo) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Clerk JS SDK -->
    @if(config('services.clerk.publishable_key'))
    <script
        async
        crossorigin="anonymous"
        data-clerk-publishable-key="{{ config('services.clerk.publishable_key') }}"
        src="https://cdn.jsdelivr.net/npm/@clerk/clerk-js@latest/dist/clerk.browser.js"
        type="text/javascript"
    ></script>
    @endif

    <!-- Estilos de Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617; /* Slate 950 */
            color: #f1f5f9;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a; 
        }
        ::-webkit-scrollbar-thumb {
            background: #334155; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569; 
        }
    </style>
</head>
<body class="min-h-screen flex antialiased selection:bg-indigo-500 selection:text-white overflow-hidden">

    <!-- =========================================================================
         Sidebar (Fijo Izquierda)
         ========================================================================= -->
    <aside class="w-72 bg-slate-900/50 backdrop-blur-2xl border-r border-slate-800/50 hidden md:flex flex-col h-screen relative z-40">
        <!-- Brand -->
        <div class="h-20 flex items-center px-8 border-b border-slate-800/50">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-300">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white group-hover:text-indigo-400 transition-colors duration-200">
                    ELITE<span class="text-indigo-500 font-extrabold">ADMIN</span>
                </span>
            </a>
        </div>

        <!-- Navegación -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mb-2">Principal</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500/10 text-indigo-400 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-500/10 text-indigo-400 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} transition-colors group">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-400' : 'group-hover:text-indigo-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Pedidos
                </div>
                @php
                    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                @if($pendingOrders > 0)
                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-rose-500 text-white shadow-[0_0_10px_rgba(244,63,94,0.5)]">{{ $pendingOrders }} nue</span>
                @endif
            </a>
            
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-indigo-500/10 text-indigo-400 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} transition-colors group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.products.*') ? 'text-indigo-400' : 'group-hover:text-indigo-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Productos
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-500/10 text-indigo-400 font-medium' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} transition-colors group">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-400' : 'group-hover:text-indigo-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Categorías
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 mt-8 mb-2">Sistema</div>
            
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/50 transition-colors group">
                <svg class="w-5 h-5 group-hover:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a la Tienda
            </a>
        </nav>
        
        <!-- User Info footer sidebar -->
        <div class="p-4 border-t border-slate-800/50 bg-slate-900/30">
            <div class="flex items-center gap-3 px-2">
                <div id="clerk-user-button-sidebar" class="h-10 w-10 rounded-full border-2 border-indigo-500 overflow-hidden flex-shrink-0 bg-slate-800 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-indigo-500 border-t-transparent"></div>
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate" id="sidebar-user-name">Administrador</p>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold flex items-center gap-1">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Conectado
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- =========================================================================
         Contenido Principal
         ========================================================================= -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black">
        
        <!-- Topbar -->
        <header class="h-20 flex items-center justify-between px-8 bg-slate-900/30 backdrop-blur-md border-b border-slate-800/50 z-30">
            <!-- Buscador simulado -->
            <div class="relative w-96 hidden md:block group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500 group-focus-within:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl leading-5 text-slate-300 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-slate-800 transition-all sm:text-sm" placeholder="Buscar pedidos, productos (Ctrl+K)..." disabled>
            </div>
            
            <div class="flex items-center gap-6 ml-auto">
                <!-- Notificaciones (Alpine JS Dropdown) -->
                @php
                    $unreadNotifications = \App\Models\AdminNotification::where('is_read', false)->latest()->get();
                @endphp
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="relative text-slate-400 hover:text-white transition-colors group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500 border border-slate-900"></span>
                        </span>
                        @endif
                    </button>
                    
                    <!-- Dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-3 w-80 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl overflow-hidden z-50 origin-top-right" style="display: none;">
                        <div class="px-4 py-3 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/50">
                            <h3 class="text-sm font-bold text-white">Notificaciones</h3>
                            @if($unreadNotifications->count() > 0)
                                <form action="{{ route('admin.notifications.read') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300">Marcar leídas</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse($unreadNotifications as $notification)
                                <a href="{{ $notification->action_url ?? '#' }}" class="block p-4 border-b border-slate-800/50 hover:bg-slate-800/40 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 p-1.5 rounded-lg {{ $notification->type == 'order' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-indigo-500/10 text-indigo-400' }}">
                                            @if($notification->type == 'order')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                            @else
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs text-white font-medium">{{ $notification->message }}</p>
                                            <p class="text-[10px] text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-slate-500 text-xs">
                                    No tienes notificaciones nuevas.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Scrollable Area -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 relative">
            
            <!-- Mensajes Flash de Notificaciones (AlpineJS) -->
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="absolute top-8 right-8 z-50 max-w-sm w-full">
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-950/90 border border-emerald-500/30 text-emerald-300 p-4 rounded-xl shadow-[0_8px_30px_rgb(16,185,129,0.12)] backdrop-blur-md">
                        <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif
        
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-rose-950/90 border border-rose-500/30 text-rose-300 p-4 rounded-xl shadow-[0_8px_30px_rgb(225,29,72,0.12)] backdrop-blur-md">
                        <svg class="w-6 h-6 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif
            </div>

            @yield('content')
            
            <footer class="mt-12 py-6 border-t border-slate-800/50 text-center">
                <p class="text-xs text-slate-500 font-medium">Ecommerce Elite &copy; 2026. Dashboard Analytics V2.</p>
            </footer>
        </main>
    </div>

    <!-- Inicialización de Clerk (Sincronización de Sesión) -->
    <script>
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

        window.addEventListener('load', async () => {
            const publishableKey = "{{ config('services.clerk.publishable_key') }}";
            
            if (!publishableKey) return;

            try {
                const clerk = await waitForClerk();
                await clerk.load({
                    afterSignInUrl: '/',
                    afterSignUpUrl: '/',
                });

                if (clerk.user && clerk.session) {
                    try {
                        const token = await clerk.session.getToken();
                        document.cookie = `__session=${token}; path=/; max-age=3600; SameSite=Lax`;
                    } catch (e) {
                        console.error('[Clerk] Error obteniendo token:', e);
                    }

                    const sidebarBtn = document.getElementById('clerk-user-button-sidebar');
                    const sidebarName = document.getElementById('sidebar-user-name');
                    
                    if (sidebarBtn) {
                        const imgUrl = clerk.user.imageUrl;
                        sidebarBtn.innerHTML = `<img src="${imgUrl}" alt="Avatar" class="h-10 w-10 object-cover cursor-pointer" title="Cerrar sesión" />`;
                        sidebarBtn.addEventListener('click', () => {
                            if (confirm('¿Deseas cerrar sesión?')) {
                                document.cookie = '__session=; path=/; max-age=0; SameSite=Lax';
                                clerk.signOut().then(() => window.location.href = '/');
                            }
                        });
                    }
                    if (sidebarName) {
                        sidebarName.innerText = clerk.user.firstName ? clerk.user.firstName + ' ' + (clerk.user.lastName || '') : (clerk.user.primaryEmailAddress?.emailAddress.split('@')[0] || 'Admin');
                    }
                } else {
                    document.cookie = '__session=; path=/; max-age=0; SameSite=Lax';
                }
            } catch (err) {
                console.error('[Clerk] Error:', err.message);
            }
        });
    </script>
</body>
</html>
