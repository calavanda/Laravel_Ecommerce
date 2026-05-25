@extends('layouts.app')

@section('title', 'Catálogo Exclusivo')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-950 py-16 border-b border-slate-900">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(99,102,241,0.08),transparent)]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 mb-4">
                ⚡ Infraestructura Docker Multi-Host
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white mb-4">
                Encuentra los mejores productos con rendimiento élite
            </h1>
            <p class="text-lg text-slate-400 leading-relaxed">
                Descubre nuestra selección curada de tecnología, moda y accesorios para el hogar. Todo servido desde nuestro cluster balanceado de alta disponibilidad.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- =========================================================================
             Filtros Laterales (Barra de Búsqueda y Categorías)
             ========================================================================= -->
        <aside class="space-y-6 lg:col-span-1">
            <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                
                <!-- Búsqueda -->
                <div class="bg-slate-950 p-6 rounded-2xl border border-slate-900 space-y-3">
                    <label for="search" class="block text-sm font-semibold text-white">Buscar producto</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ej. Auriculares..." class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Categorías -->
                <div class="bg-slate-950 p-6 rounded-2xl border border-slate-900 space-y-4">
                    <h3 class="text-sm font-semibold text-white">Categorías</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}{{ request('search') ? '?search='.request('search') : '' }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                            <span>Todas las categorías</span>
                            <span class="text-xs bg-slate-900 px-2 py-0.5 rounded border border-slate-800 text-slate-500">All</span>
                        </a>

                        @foreach($categories as $category)
                            <a href="{{ route('products.index') }}?category={{ $category->slug }}{{ request('search') ? '&search='.request('search') : '' }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request('category') == $category->slug ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                                <span>{{ $category->name }}</span>
                                <svg class="w-4 h-4 opacity-55" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Limpiar Filtros -->
                @if(request('category') || request('search'))
                    <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 w-full py-3 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-900 rounded-xl text-sm font-medium transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpiar Filtros
                    </a>
                @endif

            </form>
        </aside>

        <!-- =========================================================================
             Catálogo de Productos
             ========================================================================= -->
        <main class="lg:col-span-3 space-y-10">
            
            <!-- Resultados info -->
            <div class="flex items-center justify-between bg-slate-950/40 p-4 rounded-xl border border-slate-900/60">
                <span class="text-sm text-slate-400">
                    Mostrando <span class="text-white font-semibold">{{ $products->count() }}</span> de <span class="text-white font-semibold">{{ $products->total() }}</span> productos
                </span>
                
                @if(request('category') || request('search'))
                    <span class="text-xs bg-indigo-500/10 text-indigo-400 px-3 py-1 rounded-full border border-indigo-500/20">
                        Filtros Activos
                    </span>
                @endif
            </div>

            <!-- Grid de Productos -->
            @if($products->isEmpty())
                <div class="bg-slate-950 p-12 rounded-3xl border border-slate-900 text-center space-y-4">
                    <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center mx-auto text-indigo-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">No se encontraron productos</h3>
                    <p class="text-slate-400 text-sm max-w-sm mx-auto">Prueba buscando otra palabra clave o navegando por una categoría diferente.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition-all duration-200 mt-2">Ver todo el catálogo</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-slate-950 border border-slate-900 hover:border-slate-800 rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between shadow-lg shadow-black/10">
                            
                            <!-- Contenedor de Imagen / SVG Ilustración Premium -->
                            <div class="relative bg-slate-900 pt-[100%] overflow-hidden flex items-center justify-center border-b border-slate-900">
                                <div class="absolute inset-0 p-8 flex items-center justify-center">
                                    @include('partials.product-svg', ['path' => $product->image_path])
                                </div>
                                
                                @if($product->stock <= 5)
                                    <span class="absolute top-4 left-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full">
                                        Últimas unidades
                                    </span>
                                @elseif($product->is_featured)
                                    <span class="absolute top-4 left-4 bg-amber-500/10 border border-amber-500/20 text-amber-400 font-extrabold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full">
                                        Destacado
                                    </span>
                                @endif
                            </div>

                            <!-- Información de Producto -->
                            <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="text-xs font-semibold text-indigo-400 uppercase tracking-widest">{{ $product->category->name }}</span>
                                    <h3 class="text-lg font-bold text-white group-hover:text-indigo-400 transition-colors duration-200">
                                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-slate-400 text-xs line-clamp-2 leading-relaxed">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-900 flex items-center justify-between gap-4">
                                    <div class="space-y-0.5">
                                        <span class="text-xs text-slate-500">Precio</span>
                                        <span class="text-2xl font-extrabold text-white tracking-tight">${{ number_format($product->price, 2) }}</span>
                                    </div>

                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl transition-all duration-300 hover:scale-105 shadow-md shadow-indigo-600/10 group-hover:shadow-indigo-600/20 flex items-center justify-center" title="Añadir al carrito">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs bg-slate-900 border border-slate-800 text-slate-500 px-3 py-2 rounded-xl font-bold uppercase">Agotado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="pt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
