@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')

@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Todos los Pedidos</h1>
            <p class="text-slate-400 text-sm mt-1">Gestión integral de ventas, despachos y devoluciones.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 font-bold text-xs rounded-lg border border-indigo-500/20">
                Total: {{ $orders->total() }} pedidos
            </span>
        </div>
    </div>

    <!-- Filtros / Buscador simulado -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-2xl border border-slate-800/80 p-4 flex gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" disabled placeholder="Buscar por cliente o # rastreo..." class="w-full pl-10 pr-4 py-2 bg-slate-950 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none cursor-not-allowed opacity-50">
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-slate-950/80">
                    <tr class="text-slate-400 text-[10px] uppercase font-bold tracking-wider border-b border-slate-800/80">
                        <th class="px-6 py-4"># Rastreo</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Monto</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20">
                                    {{ $order->tracking_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white text-sm">{{ $order->customer_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $order->customer_email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-emerald-400">${{ number_format($order->total, 2) }}</div>
                                <div class="text-[10px] text-slate-500">{{ $order->items->count() }} artículos</div>
                            </td>
                            <td class="px-6 py-4">
                                <!-- Formulario para cambiar estado -->
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold uppercase tracking-wider rounded-md border focus:ring-0 focus:outline-none px-2 py-1 cursor-pointer transition-colors
                                        @if($order->status == 'pending') bg-amber-500/10 text-amber-500 border-amber-500/20
                                        @elseif($order->status == 'paid') bg-blue-500/10 text-blue-400 border-blue-500/20
                                        @elseif($order->status == 'shipped') bg-indigo-500/10 text-indigo-400 border-indigo-500/20
                                        @elseif($order->status == 'delivered') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @else bg-rose-500/10 text-rose-400 border-rose-500/20 @endif">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Enviado</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregado</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar el pedido {{ $order->tracking_number }} de forma permanente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg transition-all duration-300 opacity-50 group-hover:opacity-100" title="Eliminar pedido">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                No hay pedidos registrados en la plataforma.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="px-6 py-4 bg-slate-950/50 border-t border-slate-800/80">
            {{ $orders->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
