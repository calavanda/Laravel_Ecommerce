@extends('layouts.admin')

@section('title', 'Gestión de Categorías | Panel de Control')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editCategory: {},
    openEditModal(category) {
        this.editCategory = category;
        this.showEditModal = true;
    }
}">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-900/50 p-6 rounded-3xl border border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Categorías</h1>
            <p class="text-sm text-slate-400 mt-1">Administra las categorías de tus productos</p>
        </div>
        <button @click="showAddModal = true" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nueva Categoría
        </button>
    </div>

    <!-- Filtros / Buscador -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-2xl border border-slate-800/80 p-4">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre..." class="w-full pl-10 pr-4 py-2 bg-slate-950 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm flex items-center justify-center">Limpiar</a>
            @endif
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all">Buscar</button>
        </form>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-emerald-400 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-start gap-3">
            <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-rose-400 text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tabla -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/50 border-b border-slate-800">
                        <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Slug</th>
                        <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Productos</th>
                        <th class="p-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-800/25 transition-colors">
                            <td class="p-4 text-sm font-medium text-slate-300">#{{ $category->id }}</td>
                            <td class="p-4">
                                <span class="font-bold text-white">{{ $category->name }}</span>
                            </td>
                            <td class="p-4 text-sm text-slate-400">{{ $category->slug }}</td>
                            <td class="p-4 text-sm text-slate-300">
                                <span class="px-2 py-1 bg-slate-800 rounded-lg text-xs">{{ $category->products_count }}</span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button @click="openEditModal({{ json_encode($category) }})" class="p-2 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white rounded-lg transition-all duration-300" title="Editar">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white rounded-lg transition-all duration-300" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                No hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="p-4 border-t border-slate-800 bg-slate-900/50">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Añadir -->
    <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay sin click ni blur -->
            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-950/80 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-slate-900 border border-slate-700 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl leading-6 font-extrabold text-white" id="modal-title">
                                Nueva Categoría
                            </h3>
                            <button type="button" @click="showAddModal = false" class="text-slate-500 hover:text-white transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nombre</label>
                                <input type="text" name="name" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-900/50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-800">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar
                        </button>
                        <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-700 shadow-sm px-6 py-2.5 bg-slate-800 text-sm font-medium text-slate-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay sin click ni blur -->
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-950/80 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-slate-900 border border-slate-700 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="`/admin/categories/${editCategory?.id}`" method="POST" x-ref="editForm">
                    @csrf
                    @method('PUT')
                    <div class="bg-slate-900 px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl leading-6 font-extrabold text-white" id="modal-title">
                                Editar Categoría
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
                                <input type="text" name="name" x-model="editCategory.name" required class="w-full px-3 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
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
