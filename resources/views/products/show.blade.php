@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Volver al catálogo -->
    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white mb-8 transition-colors duration-200 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver al catálogo
    </a>

    <!-- =========================================================================
         Sección Principal del Producto (Dos Columnas)
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-slate-950/40 p-8 sm:p-12 rounded-3xl border border-slate-900 shadow-2xl backdrop-blur-sm">
        
        <!-- Columna Izquierda: Ilustración SVG -->
        <div class="bg-slate-900/60 rounded-2xl p-12 border border-slate-800/80 flex items-center justify-center min-h-[300px] sm:min-h-[450px]">
            <div class="w-full max-w-sm">
                @include('partials.product-svg', ['path' => $product->image_path])
            </div>
        </div>

        <!-- Columna Derecha: Detalles del Producto y Formulario -->
        <div class="flex flex-col justify-between space-y-8">
            <div class="space-y-6">
                <!-- Categoría -->
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                    {{ $product->category->name }}
                </span>

                <!-- Nombre -->
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $product->name }}
                </h1>

                <!-- Precio -->
                <div class="text-4xl font-black text-white tracking-tight pt-2">
                    ${{ number_format($product->price, 2) }}
                </div>

                <!-- Línea Divisoria -->
                <hr class="border-slate-900">

                <!-- Descripción -->
                <div class="space-y-2">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-widest">Descripción</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Estado del Stock (Indicador Dinámico) -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-semibold uppercase tracking-widest">Disponibilidad</span>
                        @if($product->stock > 10)
                            <span class="text-emerald-400 font-extrabold flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-emerald-400 inline-block animate-ping"></span>
                                Stock Disponible
                            </span>
                        @elseif($product->stock > 0)
                            <span class="text-amber-400 font-extrabold">¡Pocas unidades! ({{ $product->stock }} restantes)</span>
                        @else
                            <span class="text-rose-500 font-extrabold">Agotado Temporalmente</span>
                        @endif
                    </div>
                    
                    <!-- Barra de progreso de Stock -->
                    <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden border border-slate-800/80">
                        @php
                            $stockPercentage = min(($product->stock / 50) * 100, 100);
                            $barColor = 'bg-indigo-500';
                            if ($product->stock <= 5) $barColor = 'bg-rose-500';
                            elseif ($product->stock <= 15) $barColor = 'bg-amber-500';
                            else $barColor = 'bg-emerald-500';
                        @endphp
                        <div class="h-full {{ $barColor }} rounded-full transition-all duration-500" style="width: {{ $stockPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Compra -->
            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 pt-6 border-t border-slate-900">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-4">
                        
                        <!-- Selector de Cantidad -->
                        <div class="flex items-center bg-slate-900 border border-slate-800 rounded-2xl px-4 py-2 shrink-0 self-start sm:self-auto" x-data="{ qty: 1 }">
                            <button type="button" @click="if(qty > 1) qty--" class="text-slate-400 hover:text-white p-2 font-bold text-lg focus:outline-none">-</button>
                            <input type="number" name="quantity" x-model="qty" readonly class="w-12 text-center bg-transparent text-white font-extrabold focus:outline-none border-none pointer-events-none">
                            <button type="button" @click="if(qty < {{ $product->stock }}) qty++" class="text-slate-400 hover:text-white p-2 font-bold text-lg focus:outline-none">+</button>
                        </div>

                        <!-- Botón añadir al carrito -->
                        <button type="submit" class="flex-grow flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold text-base rounded-2xl shadow-xl shadow-indigo-500/10 hover:shadow-indigo-500/20 hover:scale-[1.02] transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Añadir al Carrito
                        </button>
                    </div>
                </form>
            @else
                <div class="p-4 bg-slate-900 border border-slate-800 text-slate-400 rounded-2xl text-center font-semibold text-sm">
                    Este producto no tiene existencias en este momento. Vuelve a visitarnos pronto.
                </div>
            @endif

        </div>
    </div>

    <!-- =========================================================================
         Productos Relacionados
         ========================================================================= -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-20 space-y-8">
            <h2 class="text-2xl font-bold text-white tracking-tight">Productos que podrían interesarte</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="group bg-slate-950 border border-slate-900 hover:border-slate-800 rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        
                        <!-- Miniatura SVG -->
                        <div class="relative bg-slate-900 pt-[100%] overflow-hidden flex items-center justify-center border-b border-slate-900 p-6">
                            <div class="absolute inset-0 p-6 flex items-center justify-center">
                                @include('partials.product-svg', ['path' => $related->image_path])
                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="p-6 space-y-4">
                            <div class="space-y-1">
                                <h3 class="font-bold text-white group-hover:text-indigo-400 transition-colors text-sm line-clamp-1">
                                    <a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                                </h3>
                                <span class="text-lg font-black text-white">${{ number_format($related->price, 2) }}</span>
                            </div>
                            
                            <a href="{{ route('products.show', $related->slug) }}" class="flex justify-center items-center w-full py-2.5 bg-slate-900 hover:bg-indigo-600 border border-slate-800 hover:border-indigo-600 text-slate-300 hover:text-white rounded-xl text-xs font-bold transition-all duration-300">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
