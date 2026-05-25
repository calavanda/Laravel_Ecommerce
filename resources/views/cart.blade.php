@extends('layouts.app')

@section('title', 'Mi Carrito de Compras')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <h1 class="text-3xl font-extrabold text-white tracking-tight mb-8">Mi Carrito de Compras</h1>

    @if(empty($cart))
        <!-- Carrito Vacío -->
        <div class="bg-slate-950 p-16 rounded-3xl border border-slate-900 text-center space-y-6 max-w-lg mx-auto">
            <div class="h-20 w-20 bg-slate-900 border border-slate-800 rounded-3xl flex items-center justify-center mx-auto text-slate-500">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-white">Tu carrito está vacío</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Parece que aún no has agregado ningún artículo a tu cesta de compras. ¡Explora nuestro catálogo exclusivo para encontrar excelentes ofertas!</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-[1.02] shadow-lg shadow-indigo-500/10">
                Explorar Catálogo
            </a>
        </div>
    @else
        <!-- Carrito Con Productos -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Listado de Artículos -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-slate-950/40 p-5 rounded-2xl border border-slate-900 gap-4 hover:border-slate-800/80 transition-colors duration-200">
                        
                        <!-- Miniatura SVG y Nombre -->
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 bg-slate-900 border border-slate-850 rounded-xl p-2 shrink-0 flex items-center justify-center">
                                @include('partials.product-svg', ['path' => $item['image_path']])
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-bold text-white text-sm sm:text-base hover:text-indigo-400">
                                    <a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                </h3>
                                <span class="text-xs text-slate-500 font-medium">Código: {{ $item['id'] }}</span>
                            </div>
                        </div>

                        <!-- Selector de Cantidad, Precios y Acciones -->
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto border-t sm:border-none pt-4 sm:pt-0">
                            
                            <!-- Formulario de Actualización Cantidad -->
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center bg-slate-900 border border-slate-800 rounded-xl px-2.5 py-1">
                                @csrf
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="text-slate-400 hover:text-white p-1.5 font-bold focus:outline-none">-</button>
                                <span class="w-8 text-center text-white font-extrabold text-xs">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="text-slate-400 hover:text-white p-1.5 font-bold focus:outline-none">+</button>
                            </form>

                            <!-- Subtotal del Item -->
                            <div class="text-right space-y-0.5 min-w-[70px]">
                                <span class="text-xs text-slate-500 block">Subtotal</span>
                                <span class="font-bold text-white text-sm sm:text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-500 rounded-lg hover:bg-rose-500/10 transition-colors" title="Eliminar artículo">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach

                <!-- Acciones adicionales del carrito -->
                <div class="flex justify-between items-center pt-2">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-500 hover:text-rose-500 text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5 px-3 py-2 hover:bg-rose-500/5 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Vaciar Carrito
                        </button>
                    </form>

                    <a href="{{ route('products.index') }}" class="text-indigo-400 hover:text-indigo-300 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Seguir Comprando
                    </a>
                </div>
            </div>

            <!-- Resumen de Pedido -->
            <div class="lg:col-span-1 bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-900 space-y-6 shadow-xl">
                <h3 class="text-lg font-bold text-white tracking-tight border-b border-slate-900 pb-4">Resumen del Pedido</h3>
                
                <div class="space-y-4 text-sm font-medium text-slate-400">
                    <div class="flex justify-between">
                        <span>Subtotal de productos</span>
                        <span class="text-white">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span>Envío</span>
                        @if($shipping == 0)
                            <span class="text-emerald-400 font-extrabold uppercase text-xs">Gratis</span>
                        @else
                            <span class="text-white">${{ number_format($shipping, 2) }}</span>
                        @endif
                    </div>

                    @if($subtotal < 150)
                        <div class="p-3 bg-indigo-500/5 border border-indigo-500/10 text-indigo-300 text-xs rounded-xl leading-relaxed">
                            💡 Agrega <span class="font-bold text-indigo-200">${{ number_format(150 - $subtotal, 2) }}</span> más para obtener **Envío Gratis**.
                        </div>
                    @endif

                    <hr class="border-slate-900 my-2">

                    <div class="flex justify-between items-baseline text-white">
                        <span class="text-base font-bold">Total estimado</span>
                        <span class="text-2xl font-black tracking-tight text-indigo-400">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full py-4 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold text-center block rounded-2xl shadow-lg shadow-indigo-600/15 hover:shadow-indigo-600/25 hover:scale-[1.02] transition-all duration-300 mt-2">
                    Proceder al Pago
                </a>
            </div>

        </div>
    @endif

</div>
@endsection
