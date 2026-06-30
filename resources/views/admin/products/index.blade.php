@extends('layouts.admin')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto" x-data="{ 
    showEditModal: false, 
    editProduct: {},
    openEditModal(product) {
        this.editProduct = product;
        this.showEditModal = true;
    }
}">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Catálogo Completo</h1>
            <p class="text-slate-400 text-sm mt-1">Administra el inventario, actualiza precios y descripciones.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 font-bold text-xs rounded-lg border border-emerald-500/20">
                Total: {{ $products->total() }} productos
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
            <input type="text" disabled placeholder="Buscar por nombre o categoría..." class="w-full pl-10 pr-4 py-2 bg-slate-950 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none cursor-not-allowed opacity-50">
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-slate-800/80 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-slate-950/80">
                    <tr class="text-slate-400 text-[10px] uppercase font-bold tracking-wider border-b border-slate-800/80">
                        <th class="px-6 py-4">Producto</th>
                        <th class="px-6 py-4">Precio</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Destacado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center border border-slate-700 overflow-hidden">
                                        <img src="{{ asset('images/' . $product->image_path . '.svg') }}" alt="{{ $product->name }}" class="h-6 w-6 opacity-70 group-hover:opacity-100 transition-opacity" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdib3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjOTQxM2EyIiBzdHJva2Utd2lkdGg9IjIiPjxyZWN0IHg9IjMiIHk9IjMiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxOCIgcng9IjIiIHJ5PSIyIj48L3JlY3Q+PGNpcmNsZSBjeD0iOC41IiBjeT0iOC41IiByPSIxLjUiPjwvY2lyY2xlPjxwb2x5bGluZSBwb2ludHM9IjIxIDE1IDE2IDEwIDUgMjEiPjwvcG9seWxpbmU+PC9zdmc+'">
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-sm">{{ $product->name }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $product->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-white">${{ number_format($product->price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->stock <= 5)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        {{ $product->stock }} uni. (Bajo)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        {{ $product->stock }} uni.
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_featured)
                                    <svg class="w-5 h-5 text-amber-400 drop-shadow-[0_0_5px_rgba(251,191,36,0.5)]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal({{ json_encode($product) }})" class="p-2 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white rounded-lg transition-all duration-300" title="Editar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Eliminar producto {{ $product->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg transition-all duration-300" title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                No hay productos en el catálogo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="px-6 py-4 bg-slate-950/50 border-t border-slate-800/80">
            {{ $products->links('pagination::tailwind') }}
        </div>
        @endif
    </div>

    <!-- Modal de Edición (Alpine JS) -->
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showEditModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-slate-900 border border-slate-700 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="`/admin/product/${editProduct?.id}`" method="POST" x-ref="editForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl leading-6 font-extrabold text-white" id="modal-title">
                                Editar Producto
                            </h3>
                            <button type="button" @click="showEditModal = false" class="text-slate-500 hover:text-white transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nombre</label>
                                <input type="text" name="name" x-model="editProduct.name" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Categoría</label>
                                <select name="category_id" x-model="editProduct.category_id" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 appearance-none">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Precio</label>
                                    <input type="number" step="0.01" name="price" x-model="editProduct.price" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Stock</label>
                                    <input type="number" name="stock" x-model="editProduct.stock" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Descripción</label>
                                <textarea name="description" x-model="editProduct.description" required rows="3" class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-xs focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"></textarea>
                            </div>

                            <div class="flex items-center gap-3 py-2 bg-slate-950/50 px-3 rounded-xl border border-slate-800">
                                <input type="checkbox" name="is_featured" id="edit_is_featured" value="1" :checked="editProduct?.is_featured == 1" class="h-4 w-4 bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500/50 rounded transition-colors cursor-pointer">
                                <label for="edit_is_featured" class="text-xs font-medium text-white cursor-pointer select-none">Destacar en Portada</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-900/50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-800">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar Cambios
                        </button>
                        <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-700 shadow-sm px-6 py-2.5 bg-slate-800 text-sm font-medium text-slate-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
