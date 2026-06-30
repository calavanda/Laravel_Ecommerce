@extends('layouts.app')

@section('title', '¡Pedido Completado!')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Contenedor Principal Éxito -->
    <div class="bg-slate-950 border border-slate-900 rounded-3xl p-8 sm:p-12 text-center space-y-8 shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(16,185,129,0.06),transparent)]"></div>

        <!-- Icono Check Animado SVG -->
        <div class="relative">
            <div class="h-24 w-24 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/5">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Mensajes -->
        <div class="space-y-3 relative">
            <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">¡Transacción Exitosa!</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">¡Gracias por tu compra!</h1>
            <p class="text-slate-400 text-sm max-w-lg mx-auto leading-relaxed">Hemos recibido tu pedido correctamente. Hemos guardado tu información y estamos preparando la orden en nuestras bodegas de distribución.</p>
        </div>

        <!-- Tarjeta del Código de Rastreo (Glow Widget) -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl max-w-md mx-auto space-y-2.5 relative">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Código de Seguimiento</span>
            <div class="flex items-center justify-center gap-2 select-all">
                <span class="text-lg sm:text-xl font-black text-indigo-400 tracking-wider font-mono">
                    {{ $order->tracking_number }}
                </span>
            </div>
            <p class="text-[10px] text-slate-500">Usa este identificador para rastrear el progreso de tu envío con soporte de alta disponibilidad.</p>
        </div>

        <!-- Detalles del Pedido -->
        <div class="border-t border-slate-900 pt-8 text-left space-y-6">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Resumen del Envío</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div class="space-y-1">
                    <span class="text-slate-500 text-xs uppercase font-medium">Cliente</span>
                    <p class="text-white font-bold">{{ $order->customer_name }}</p>
                    <p class="text-slate-400 text-xs">{{ $order->customer_email }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-slate-500 text-xs uppercase font-medium">Dirección de Entrega</span>
                    <p class="text-white font-bold">{{ $order->address }}</p>
                    <p class="text-slate-400 text-xs">{{ $order->city }}, C.P. {{ $order->zip_code }}</p>
                </div>
            </div>

            <!-- Listado de Artículos Comprados -->
            <div class="bg-slate-900/40 border border-slate-900 rounded-2xl p-4 sm:p-6 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-slate-500 text-xs uppercase font-semibold text-left border-b border-slate-900 pb-2">
                            <th class="pb-3">Producto</th>
                            <th class="pb-3 text-center">Cantidad</th>
                            <th class="pb-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900/60">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3.5 flex items-center gap-3">
                                    <div class="h-8 w-8 bg-slate-900 border border-slate-850 rounded-lg p-1 shrink-0 flex items-center justify-center">
                                        @include('partials.product-svg', ['path' => $item->product->image_path])
                                    </div>
                                    <span class="font-bold text-white text-xs sm:text-sm line-clamp-1">{{ $item->product->name }}</span>
                                </td>
                                <td class="py-3.5 text-center text-slate-300 font-semibold">{{ $item->quantity }}</td>
                                <td class="py-3.5 text-right font-bold text-white">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="border-t border-slate-900 pt-4 flex justify-between items-baseline mt-2">
                    <span class="text-xs font-semibold text-slate-500 uppercase">Total Pagado</span>
                    <span class="text-xl font-black text-indigo-400">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Botones Finales -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('checkout.invoice', $order->tracking_number) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-[1.01]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimir Factura
            </a>
            <a href="{{ route('products.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-[1.01]">
                Seguir Comprando
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection
