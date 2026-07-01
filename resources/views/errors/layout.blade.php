<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EliteShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow: hidden;
        }
        .glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, rgba(15,23,42,0) 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            animation: pulse 4s infinite alternate ease-in-out;
        }
        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            100% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">
    
    <div class="glow"></div>
    
    <div class="max-w-2xl w-full px-6 text-center z-10 relative">
        <!-- Logo -->
        <div class="mb-12">
            <a href="/" class="text-3xl font-black text-white tracking-tight flex items-center justify-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                ELITESHOP
            </a>
        </div>

        <!-- Error Content -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-10 sm:p-16 rounded-3xl shadow-2xl">
            <div class="text-indigo-500 font-black text-8xl sm:text-9xl tracking-tighter mb-4 drop-shadow-lg">
                @yield('code')
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-4">
                @yield('message')
            </h1>
            
            <p class="text-slate-400 text-sm sm:text-base leading-relaxed mb-10 max-w-lg mx-auto">
                @yield('description')
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ url()->previous() }}" class="w-full sm:w-auto px-8 py-3.5 bg-slate-800 text-white font-bold rounded-xl shadow-lg hover:bg-slate-700 transition border border-slate-700">
                    Regresar
                </a>
                <a href="/" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Ir al Inicio
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-12 text-slate-500 text-xs font-medium uppercase tracking-widest">
            &copy; {{ date('Y') }} EliteShop. Sistema Seguro.
        </div>
    </div>
</body>
</html>
