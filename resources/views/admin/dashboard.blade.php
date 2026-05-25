@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8 max-w-[1400px] mx-auto">
    
    <!-- Encabezado de Página -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Panorama General</h1>
            <p class="text-slate-400 text-sm mt-1">Monitorización de ventas, inventario crítico y gestión de administradores.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 text-white font-medium text-sm rounded-xl border border-slate-700 transition-colors shadow-lg backdrop-blur-md flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Exportar CSV
            </button>
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.4)] transition-all duration-300 hover:scale-105 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Crear Campaña
            </button>
        </div>
    </div>

    <!-- =========================================================================
         Métricas Principales (KPIs con Glassmorphism)
         ========================================================================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Tarjeta 1: Ventas Totales -->
        <div class="relative overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 p-6 rounded-3xl group hover:border-emerald-500/50 transition-colors duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-500/20 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Ventas Totales</p>
                    <h3 class="text-3xl font-black text-white tracking-tight">${{ number_format($totalSales, 2) }}</h3>
                </div>
                <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-400 border border-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-emerald-400 font-semibold gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                +14.5% <span class="text-slate-500 font-normal">vs mes pasado</span>
            </div>
        </div>

        <!-- Tarjeta 2: Pedidos Procesados -->
        <div class="relative overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 p-6 rounded-3xl group hover:border-indigo-500/50 transition-colors duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-indigo-500/30 transition-all"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pedidos Procesados</p>
                    <h3 class="text-3xl font-black text-white tracking-tight">{{ $totalOrders }}</h3>
                </div>
                <div class="p-2.5 bg-indigo-500/10 rounded-xl text-indigo-400 border border-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-indigo-400 font-semibold gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                +8.2% <span class="text-slate-500 font-normal">esta semana</span>
            </div>
        </div>

        <!-- Tarjeta 3: Conversión -->
        <div class="relative overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 p-6 rounded-3xl group hover:border-violet-500/50 transition-colors duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-violet-500/20 rounded-full blur-2xl group-hover:bg-violet-500/30 transition-all"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tasa de Conversión</p>
                    <h3 class="text-3xl font-black text-white tracking-tight">4.8%</h3>
                </div>
                <div class="p-2.5 bg-violet-500/10 rounded-xl text-violet-400 border border-violet-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-rose-400 font-semibold gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
                -1.2% <span class="text-slate-500 font-normal">ayer</span>
            </div>
        </div>

        <!-- Tarjeta 4: Salud del Sistema -->
        <div class="relative overflow-hidden bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 p-6 rounded-3xl group hover:border-emerald-500/50 transition-colors duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-500/20 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition-all"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Salud del Entorno</p>
                    <h3 class="text-3xl font-black text-white tracking-tight flex items-center gap-2">
                        99.9%
                    </h3>
                </div>
                <div class="p-2.5 bg-slate-800 rounded-xl text-white border border-slate-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-emerald-400 font-semibold gap-1.5">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Operativo <span class="text-slate-500 font-normal">(Nginx LB M4)</span>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         Layout Principal de 2 Columnas
         ========================================================================= -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Columna Izquierda: Pedidos y Administradores -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- Tabla de Pedidos -->
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl">
                <div class="px-6 py-5 border-b border-slate-800/80 flex items-center justify-between bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Pedidos Recientes
                    </h3>
                    <a href="#" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition-colors">Ver Todos &rarr;</a>
                </div>
                
                <div class="p-0">
                    @if($orders->isEmpty())
                        <div class="text-center py-16 text-slate-500 text-sm flex flex-col items-center">
                            <svg class="w-12 h-12 text-slate-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p>No hay pedidos registrados en la base de datos todavía.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left whitespace-nowrap">
                                <thead class="bg-slate-950/50">
                                    <tr class="text-slate-400 text-[10px] uppercase font-bold tracking-wider border-b border-slate-800/80">
                                        <th class="px-6 py-4">Ref / Cliente</th>
                                        <th class="px-6 py-4">Total</th>
                                        <th class="px-6 py-4">Estado</th>
                                        <th class="px-6 py-4">Fecha</th>
                                        <th class="px-6 py-4 text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/50">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-slate-800/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center font-mono text-[10px] text-slate-400 font-bold border border-slate-700">
                                                        {{ substr($order->tracking_number, -4) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-white text-sm">{{ $order->customer_name }}</div>
                                                        <div class="text-[11px] text-slate-500">{{ $order->customer_email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-black text-white">${{ number_format($order->total, 2) }}</div>
                                                <div class="text-[10px] text-slate-500">{{ $order->items->count() }} artículo(s)</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-slate-400">
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-slate-950/30 border-t border-slate-800/80">
                            {{ $orders->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gestión de Administradores (Rediseñada) -->
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl">
                <div class="px-6 py-5 border-b border-slate-800/80 flex items-center justify-between bg-slate-900/50">
                    <h3 class="text-lg font-bold text-white tracking-tight flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Control de Accesos (Admins)
                    </h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-5 gap-8">
                    <!-- Formulario (Col-2) -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="h-full flex flex-col justify-center bg-slate-950/50 p-5 rounded-2xl border border-slate-800">
                            <h4 class="text-sm font-bold text-white mb-2">Otorgar Permisos</h4>
                            <p class="text-[11px] text-slate-400 mb-4 leading-relaxed">Asigna el rol de administrador ingresando un correo electrónico. El usuario obtendrá acceso instantáneo al panel tras iniciar sesión.</p>
                            
                            <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <input type="email" name="email" required placeholder="admin@ecommerce.com" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all shadow-inner">
                                </div>
                                <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(79,70,229,0.3)]">
                                    Añadir Administrador
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lista (Col-3) -->
                    <div class="md:col-span-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Usuarios con Privilegios (BD)</h4>
                        
                        <div class="space-y-3 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar">
                            @if(isset($dbAdmins) && $dbAdmins->count() > 0)
                                @foreach($dbAdmins as $admin)
                                    <div class="flex items-center justify-between p-3.5 bg-slate-800/40 hover:bg-slate-800/60 transition-colors border border-slate-700/50 rounded-xl group">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-white leading-tight">{{ $admin->name }}</div>
                                                <div class="text-[11px] text-slate-400">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                        
                                        @if(auth()->id() !== $admin->id)
                                        <form action="{{ route('admin.admins.remove', $admin->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas revocar los permisos de {{ $admin->email }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg transition-all duration-300 opacity-50 group-hover:opacity-100" title="Revocar permisos">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-[10px] px-2.5 py-1 bg-slate-700/50 text-slate-300 rounded font-bold uppercase tracking-wider border border-slate-600">Tú</span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 px-4 border border-dashed border-slate-700 rounded-xl bg-slate-900/30">
                                    <p class="text-xs text-slate-500">No hay administradores registrados en la base de datos.</p>
                                    <p class="text-[10px] text-slate-600 mt-1">Solo los listados en el .env tienen acceso actualmente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Columna Derecha: Alertas y Formularios -->
        <div class="space-y-8">
            
            <!-- Alertas de Stock Bajo -->
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl relative">
                <!-- Efecto de borde superior rojo -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-orange-500"></div>
                
                <div class="px-6 py-5 border-b border-slate-800/80 flex items-center justify-between bg-slate-900/50">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Stock Crítico
                    </h3>
                    <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-400 text-[10px] font-black border border-rose-500/30">{{ $lowStockProducts->count() }}</span>
                </div>
                
                <div class="p-4">
                    @if($lowStockProducts->isEmpty())
                        <div class="text-center py-6 text-emerald-400/80 text-sm flex flex-col items-center">
                            <div class="h-12 w-12 rounded-full bg-emerald-500/10 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            Inventario Saludable
                        </div>
                    @else
                        <div class="space-y-3 max-h-[250px] overflow-y-auto pr-1 custom-scrollbar">
                            @foreach($lowStockProducts as $lowStock)
                                <div class="bg-slate-950/60 border border-rose-900/30 hover:border-rose-500/50 transition-colors p-3 rounded-xl flex items-center justify-between gap-3 group">
                                    <div class="overflow-hidden">
                                        <div class="text-xs font-bold text-white truncate">{{ $lowStock->name }}</div>
                                        <div class="text-[10px] text-rose-400 font-medium">Quedan {{ $lowStock->stock }} unidades</div>
                                    </div>
                                    
                                    <form action="{{ route('admin.product.update-stock', $lowStock->id) }}" method="POST" class="flex items-center gap-1.5 shrink-0">
                                        @csrf
                                        <input type="number" name="stock" value="{{ $lowStock->stock }}" required class="w-14 text-center py-1.5 bg-slate-900 border border-slate-700 rounded-lg text-xs text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">
                                        <button type="submit" class="p-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-colors shadow-lg" title="Actualizar Stock">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Formulario Crear Producto -->
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl">
                <div class="px-6 py-5 border-b border-slate-800/80 bg-slate-900/50">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Añadir al Catálogo
                    </h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.product.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nombre del Producto</label>
                            <input type="text" name="name" id="name" required placeholder="Ej. MacBook Pro M3" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <div>
                            <label for="category_id" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Categoría</label>
                            <select name="category_id" id="category_id" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors appearance-none">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Precio ($)</label>
                                <input type="number" step="0.01" name="price" id="price" required placeholder="0.00" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label for="stock" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Unidades</label>
                                <input type="number" name="stock" id="stock" required placeholder="10" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="image_path" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Avatar / SVG</label>
                            <select name="image_path" id="image_path" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors appearance-none">
                                <option value="tech-headphones">Auriculares Pro</option>
                                <option value="tech-keyboard">Teclado RGB</option>
                                <option value="tech-watch">Reloj Active</option>
                                <option value="tech-solar">Cargador Solar</option>
                                <option value="fashion-backpack">Mochila Urbana</option>
                                <option value="fashion-glasses">Gafas de Sol</option>
                                <option value="fashion-shoes">Zapatillas Sport</option>
                                <option value="home-coffee">Máquina de Café</option>
                                <option value="home-lamp">Lámpara LED</option>
                                <option value="home-organizer">Organizador Escritorio</option>
                                <option value="sport-bottle">Botella Térmica</option>
                                <option value="sport-mat">Esterilla Yoga</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Descripción</label>
                            <textarea name="description" id="description" required rows="2" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-colors custom-scrollbar" placeholder="Breve descripción del producto..."></textarea>
                        </div>

                        <div class="flex items-center gap-3 py-2 bg-slate-950/50 px-3 rounded-xl border border-slate-800">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" class="h-4 w-4 bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500/50 rounded transition-colors cursor-pointer">
                            <label for="is_featured" class="text-xs font-medium text-white cursor-pointer select-none">Mostrar en Portada (Destacado)</label>
                        </div>

                        <button type="submit" class="w-full py-3 bg-white hover:bg-slate-200 text-slate-900 font-extrabold text-xs tracking-wide uppercase rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(255,255,255,0.2)] mt-2">
                            Publicar Producto
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Estilos extra para scrollbars dentro del dashboard si son necesarios */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155; 
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #475569; 
}
</style>
@endsection
