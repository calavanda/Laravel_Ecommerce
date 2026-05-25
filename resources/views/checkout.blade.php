@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <h1 class="text-3xl font-extrabold text-white tracking-tight mb-8">Finalizar Compra</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Formulario de Checkout (Columna Izquierda / Ancha) -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Datos de Facturación / Envío -->
                <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-900 space-y-6">
                    <h3 class="text-lg font-bold text-white tracking-tight flex items-center gap-2 border-b border-slate-900 pb-4">
                        <span class="h-6 w-6 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-xs">1</span>
                        Información de Envío
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nombre Completo -->
                        <div class="sm:col-span-2 space-y-2">
                            <label for="customer_name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre Completo</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-650 transition-all duration-200">
                            @error('customer_name')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="sm:col-span-2 space-y-2">
                            <label for="customer_email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Correo Electrónico</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-650 transition-all duration-200">
                            @error('customer_email')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dirección -->
                        <div class="sm:col-span-2 space-y-2">
                            <label for="address" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Dirección de Envío</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required placeholder="Calle, número, colonia..." class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-all duration-200">
                            @error('address')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ciudad -->
                        <div class="space-y-2">
                            <label for="city" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Ciudad</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" required class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            @error('city')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código Postal -->
                        <div class="space-y-2">
                            <label for="zip_code" class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Código Postal</label>
                            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" required class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            @error('zip_code')
                                <p class="text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pago Simulado (Para pruebas del entorno) -->
                <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-900 space-y-6">
                    <h3 class="text-lg font-bold text-white tracking-tight flex items-center gap-2 border-b border-slate-900 pb-4">
                        <span class="h-6 w-6 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-xs">2</span>
                        Método de Pago (Simulado)
                    </h3>
                    
                    <div class="p-4 bg-indigo-500/5 border border-indigo-500/15 rounded-2xl flex items-start gap-3 text-indigo-300 text-xs leading-relaxed">
                        <svg class="w-5 h-5 text-indigo-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <span class="font-bold text-indigo-200 block mb-0.5">Entorno de Demostración y Pruebas</span>
                            Esta pasarela está en modo simulado para validar el correcto funcionamiento de tus bases de datos e infraestructura distribuida. No se realizarán cobros reales. Puedes escribir cualquier dato en la tarjeta.
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Tarjeta número -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Número de Tarjeta</label>
                            <input type="text" placeholder="4242 •••• •••• 4242" class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-all duration-200">
                        </div>

                        <!-- Vencimiento y CVV -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Vencimiento</label>
                                <input type="text" placeholder="MM/AA" class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-all duration-200">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">CVC / CVV</label>
                                <input type="text" placeholder="123" class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600 transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="w-full py-4.5 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold text-base rounded-2xl shadow-xl shadow-indigo-600/10 hover:shadow-indigo-600/20 hover:scale-[1.01] transition-all duration-300">
                    Confirmar Pedido (${{ number_format($total, 2) }})
                </button>
            </form>
        </div>

        <!-- Desglose de Productos (Columna Derecha / Estrecha) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-900 space-y-6 shadow-xl">
                <h3 class="text-lg font-bold text-white tracking-tight border-b border-slate-900 pb-4">Artículos del Pedido</h3>
                
                <div class="divide-y divide-slate-900 max-h-80 overflow-y-auto pr-1">
                    @foreach($cart as $item)
                        <div class="flex items-center justify-between py-3 gap-3">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-slate-900 border border-slate-850 rounded-lg p-1 shrink-0 flex items-center justify-center">
                                    @include('partials.product-svg', ['path' => $item['image_path']])
                                </div>
                                <div class="space-y-0.5">
                                    <h4 class="font-bold text-white text-xs line-clamp-1">{{ $item['name'] }}</h4>
                                    <span class="text-[10px] text-slate-500 font-semibold uppercase">{{ $item['quantity'] }} unidad(es)</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-slate-900 pt-4 space-y-3 text-xs font-medium text-slate-400">
                    <div class="flex justify-between">
                        <span>Subtotal de productos</span>
                        <span class="text-white">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Envío</span>
                        @if($shipping == 0)
                            <span class="text-emerald-400 font-extrabold uppercase text-[10px]">Gratis</span>
                        @else
                            <span class="text-white">${{ number_format($shipping, 2) }}</span>
                        @endif
                    </div>

                    <hr class="border-slate-900">

                    <div class="flex justify-between items-baseline text-white pt-2">
                        <span class="text-sm font-bold">Total a Pagar</span>
                        <span class="text-xl font-black text-indigo-400">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
