@php
    // Evitar errores si viene nulo
    $path = $path ?? 'tech-headphones';
@endphp

@switch($path)
    @case('tech-headphones')
        <!-- Auriculares -->
        <svg class="w-full h-full max-h-44 text-indigo-500 drop-shadow-[0_0_15px_rgba(99,102,241,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="headGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#6366f1" />
                    <stop offset="100%" stop-color="#4f46e5" />
                </linearGradient>
            </defs>
            <path d="M3 14c0-4.97 4.03-9 9-9s9 4.03 9 9" stroke="url(#headGrad)" stroke-width="2" stroke-linecap="round" />
            <rect x="2" y="12" width="4" height="6" rx="2" fill="url(#headGrad)" />
            <rect x="18" y="12" width="4" height="6" rx="2" fill="url(#headGrad)" />
            <path d="M4 15v-1a8 8 0 0116 0v1" stroke="#818cf8" stroke-width="1" />
        </svg>
        @break

    @case('tech-keyboard')
        <!-- Teclado -->
        <svg class="w-full h-full max-h-44 text-violet-500 drop-shadow-[0_0_15px_rgba(139,92,246,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="keyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#8b5cf6" />
                    <stop offset="100%" stop-color="#6d28d9" />
                </linearGradient>
            </defs>
            <rect x="2" y="6" width="20" height="12" rx="3" fill="none" stroke="url(#keyGrad)" stroke-width="2" />
            <!-- Teclas simuladas -->
            <rect x="4" y="8" width="2" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="7" y="8" width="2" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="10" y="8" width="2" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="13" y="8" width="2" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="16" y="8" width="4" height="2" rx="0.5" fill="#818cf8" />
            <rect x="4" y="11" width="3" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="8" y="11" width="8" height="2" rx="0.5" fill="url(#keyGrad)" />
            <rect x="17" y="11" width="3" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="4" y="14" width="2" height="2" rx="0.5" fill="#a78bfa" />
            <rect x="7" y="14" width="10" height="2" rx="0.5" fill="#c084fc" />
            <rect x="18" y="14" width="2" height="2" rx="0.5" fill="#a78bfa" />
        </svg>
        @break

    @case('tech-watch')
        <!-- Reloj Inteligente -->
        <svg class="w-full h-full max-h-44 text-emerald-500 drop-shadow-[0_0_15px_rgba(16,185,129,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="watchGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#10b981" />
                    <stop offset="100%" stop-color="#047857" />
                </linearGradient>
            </defs>
            <!-- Correa -->
            <rect x="8" y="2" width="8" height="20" rx="3" fill="#1e293b" stroke="#334155" stroke-width="1" />
            <!-- Pantalla principal -->
            <rect x="6" y="6" width="12" height="12" rx="3" fill="url(#watchGrad)" stroke="#34d399" stroke-width="1.5" />
            <!-- Círculo interior -->
            <circle cx="12" cy="12" r="3" fill="none" stroke="#a7f3d0" stroke-width="1" />
            <path d="M12 10v2h2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('tech-solar')
        <!-- Cargador Solar -->
        <svg class="w-full h-full max-h-44 text-amber-500 drop-shadow-[0_0_15px_rgba(245,158,11,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="5" y="3" width="14" height="18" rx="2" fill="none" stroke="#f59e0b" stroke-width="2" />
            <!-- Panel solar -->
            <rect x="7" y="5" width="10" height="9" fill="#1e293b" rx="1" />
            <line x1="12" y1="5" x2="12" y2="14" stroke="#d97706" stroke-width="1" />
            <line x1="7" y1="8" x2="17" y2="8" stroke="#d97706" stroke-width="1" />
            <line x1="7" y1="11" x2="17" y2="11" stroke="#d97706" stroke-width="1" />
            <!-- LEDs y Puertos -->
            <circle cx="9" cy="17" r="1" fill="#10b981" />
            <circle cx="12" cy="17" r="1" fill="#10b981" />
            <circle cx="15" cy="17" r="1" fill="#3b82f6" />
            <rect x="9" y="19" width="6" height="1" rx="0.5" fill="#f59e0b" />
        </svg>
        @break

    @case('fashion-backpack')
        <!-- Mochila -->
        <svg class="w-full h-full max-h-44 text-sky-500 drop-shadow-[0_0_15px_rgba(14,165,233,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="backGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#0ea5e9" />
                    <stop offset="100%" stop-color="#0369a1" />
                </linearGradient>
            </defs>
            <!-- Asa -->
            <path d="M9 5c0-1.5 1-2 3-2s3 .5 3 2" stroke="#0ea5e9" stroke-width="2" fill="none" />
            <!-- Cuerpo mochila -->
            <path d="M5 8c0-3 3-4 7-4s7 1 7 4v11c0 2-2 3-7 3s-7-1-7-3V8z" fill="url(#backGrad)" />
            <!-- Bolsillo delantero -->
            <path d="M7 13h10v6c0 1.5-1.5 2-5 2s-5-.5-5-2v-6z" fill="#0284c7" stroke="#38bdf8" stroke-width="1.5" />
            <line x1="7" y1="13" x2="17" y2="13" stroke="#e0f2fe" stroke-width="1.5" />
        </svg>
        @break

    @case('fashion-glasses')
        <!-- Gafas de Sol -->
        <svg class="w-full h-full max-h-44 text-pink-500 drop-shadow-[0_0_15px_rgba(236,72,153,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M2 10s3-1 4-1 4 1 4 1 3-1 4-1 4 1 4 1" stroke="#ec4899" stroke-width="2" stroke-linecap="round" />
            <circle cx="7" cy="12" r="4" fill="#f87171" fill-opacity="0.2" stroke="#ec4899" stroke-width="2.5" />
            <circle cx="17" cy="12" r="4" fill="#f87171" fill-opacity="0.2" stroke="#ec4899" stroke-width="2.5" />
            <!-- Patillas -->
            <path d="M3 10c-1-1-2-4-2-4M21 10c1-1 2-4 2-4" stroke="#db2777" stroke-width="2" stroke-linecap="round" />
        </svg>
        @break

    @case('fashion-shoes')
        <!-- Zapatillas -->
        <svg class="w-full h-full max-h-44 text-rose-500 drop-shadow-[0_0_15px_rgba(244,63,94,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="shoeGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#f43f5e" />
                    <stop offset="100%" stop-color="#be123c" />
                </linearGradient>
            </defs>
            <!-- Suela -->
            <path d="M3 17c1-.5 5-.5 7-1s6 2 11 0l.5 1.5c-4 2-10 1-13 1s-4.5-.5-5.5-1.5z" fill="#ffffff" />
            <!-- Cuerpo tenis -->
            <path d="M4 15.5C4 12 6 9 10 9c2.5 0 3.5 1.5 5 1.5s5-2 6.5-1v6C17.5 17.5 9 17 4 15.5z" fill="url(#shoeGrad)" />
            <!-- Cordones -->
            <line x1="11" y1="10" x2="13" y2="12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
            <line x1="12" y1="9" x2="14" y2="11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('home-coffee')
        <!-- Cafetera -->
        <svg class="w-full h-full max-h-44 text-yellow-500 drop-shadow-[0_0_15px_rgba(234,179,8,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="6" y="3" width="12" height="18" rx="2" fill="none" stroke="#eab308" stroke-width="2" />
            <!-- Depósito agua -->
            <rect x="8" y="5" width="8" height="5" fill="#fef08a" fill-opacity="0.3" rx="0.5" />
            <!-- Jarra café -->
            <path d="M8 13h8v6c0 1-1 1-4 1s-4 0-4-1v-6z" fill="#78350f" fill-opacity="0.6" stroke="#eab308" stroke-width="1.5" />
            <path d="M16 14h2v4h-2" stroke="#eab308" stroke-width="1.5" fill="none" />
            <line x1="6" y1="11" x2="18" y2="11" stroke="#ca8a04" stroke-width="2" />
        </svg>
        @break

    @case('home-lamp')
        <!-- Lámpara -->
        <svg class="w-full h-full max-h-44 text-cyan-500 drop-shadow-[0_0_15px_rgba(6,182,212,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <!-- Base -->
            <ellipse cx="12" cy="20" rx="6" ry="1.5" fill="#0891b2" />
            <!-- Brazo de la lámpara -->
            <path d="M12 20V8c0-2-1-3-4-3" stroke="#06b6d4" stroke-width="2.5" stroke-linecap="round" fill="none" />
            <!-- Foco/Pantalla -->
            <path d="M6 5h4l1 3H5L6 5z" fill="#22d3ee" stroke="#0891b2" stroke-width="1.5" />
            <!-- Resplandor -->
            <polygon points="5,8 3,14 13,14 11,8" fill="#e0f7fa" fill-opacity="0.2" />
        </svg>
        @break

    @case('home-organizer')
        <!-- Organizador madera -->
        <svg class="w-full h-full max-h-44 text-amber-700 drop-shadow-[0_0_15px_rgba(180,83,9,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <!-- Estructura principal -->
            <rect x="3" y="8" width="18" height="12" rx="1" fill="none" stroke="#b45309" stroke-width="2" />
            <!-- Divisiones -->
            <line x1="9" y1="8" x2="9" y2="20" stroke="#b45309" stroke-width="1.5" />
            <line x1="15" y1="8" x2="15" y2="20" stroke="#b45309" stroke-width="1.5" />
            <line x1="3" y1="14" x2="9" y2="14" stroke="#d97706" stroke-width="1" />
            <!-- Libros/Notas dentro -->
            <rect x="10" y="10" width="4" height="10" fill="#f59e0b" rx="0.5" />
            <rect x="5" y="10" width="3" height="4" fill="#3b82f6" rx="0.5" />
        </svg>
        @break

    @case('sport-bottle')
        <!-- Botella térmica -->
        <svg class="w-full h-full max-h-44 text-purple-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="botGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" />
                    <stop offset="100%" stop-color="#7e22ce" />
                </linearGradient>
            </defs>
            <path d="M8 7h8v12c0 1.5-1.5 2-4 2s-4-.5-4-2V7z" fill="url(#botGrad)" />
            <!-- Cuello -->
            <rect x="9.5" y="4" width="5" height="3" fill="#6b21a8" rx="0.5" />
            <!-- Tapón -->
            <rect x="11" y="2" width="2" height="2" fill="#d8b4fe" rx="0.2" />
            <line x1="8" y1="11" x2="16" y2="11" stroke="#d8b4fe" stroke-width="1" />
        </svg>
        @break

    @case('sport-mat')
        <!-- Esterilla yoga -->
        <svg class="w-full h-full max-h-44 text-teal-500 drop-shadow-[0_0_15px_rgba(20,184,166,0.25)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <defs>
                <linearGradient id="matGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#14b8a6" />
                    <stop offset="100%" stop-color="#0f766e" />
                </linearGradient>
            </defs>
            <!-- Mat enrollada (Elipse frontal) -->
            <ellipse cx="6" cy="12" rx="3" ry="6" fill="url(#matGrad)" stroke="#2dd4bf" stroke-width="1.5" />
            <ellipse cx="6" cy="12" rx="1.5" ry="3" fill="#111827" />
            <!-- Cuerpo -->
            <path d="M6 6h12c1.5 0 2 2.5 2 6s-.5 6-2 6H6" fill="none" stroke="url(#matGrad)" stroke-width="12" stroke-linecap="round" />
            <!-- Cintas -->
            <path d="M9 6v12M15 6v12" stroke="#ffffff" stroke-width="1.5" />
        </svg>
        @break

    @default
        <!-- Caja genérica (Para productos creados en Admin) -->
        <svg class="w-full h-full max-h-44 text-indigo-400 drop-shadow-[0_0_15px_rgba(99,102,241,0.15)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4" stroke="#6366f1" stroke-width="2" stroke-linejoin="round" />
        </svg>
@endswitch
