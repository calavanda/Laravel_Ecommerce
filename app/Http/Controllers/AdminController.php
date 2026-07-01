<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard administrativo: Estadísticas y listado de pedidos.
     */
    public function index()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        
        $orders = Order::with('items.product')->latest()->paginate(10);
        $categories = Category::all();
        $dbAdmins = User::where('is_admin', true)->get();

        return view('admin.dashboard', compact('totalSales', 'totalOrders', 'lowStockProducts', 'orders', 'categories', 'dbAdmins'));
    }

    /**
     * Crear un nuevo producto en el catálogo.
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'image_path' => 'nullable|string',
        ]);

        $product = Product::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'category_id' => $request->input('category_id'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'image_path' => $request->input('image_path', 'tech-headphones'), // Valor por defecto
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Producto '{$product->name}' creado correctamente.");
    }

    /**
     * Actualizar el stock de un producto directamente.
     */
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'stock' => $request->input('stock'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Stock del producto '{$product->name}' actualizado a {$product->stock}.");
    }

    /**
     * Añadir un administrador (por email).
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->input('email');

        // Buscar si ya existe el usuario
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update(['is_admin' => true]);
            return redirect()->route('admin.dashboard')->with('success', "El usuario '{$email}' ahora es administrador.");
        }

        // Si no existe, creamos un registro placeholder para cuando inicie sesión
        User::create([
            'name' => explode('@', $email)[0],
            'email' => $email,
            'is_admin' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Se ha otorgado permiso de administrador a '{$email}'. Se aplicará cuando inicie sesión.");
    }

    /**
     * Revocar permisos de administrador.
     */
    public function removeAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Evitar que el administrador se elimine a sí mismo accidentalmente si es el único
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.dashboard')->with('error', "No puedes revocar tus propios permisos desde aquí.");
        }

        $user->update(['is_admin' => false]);

        return redirect()->route('admin.dashboard')->with('success', "Se han revocado los permisos de administrador a '{$user->email}'.");
    }

    // ==========================================
    // Módulo de Pedidos (Orders)
    // ==========================================
    
    public function orders()
    {
        $orders = Order::with('items.product')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', "Estado del pedido #{$order->tracking_number} actualizado a '{$order->status}'.");
    }

    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();

        return back()->with('success', 'Pedido eliminado correctamente del sistema.');
    }

    // ==========================================
    // Módulo de Productos (Products)
    // ==========================================

    public function products(Request $request)
    {
        $search = $request->query('search');
        $products = Product::with('category')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_featured' => $request->has('is_featured'),
        ]);

        return back()->with('success', "Producto '{$product->name}' actualizado correctamente.");
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Producto eliminado del catálogo.');
    }

    // ==========================================
    // Módulo de Categorías (Categories)
    // ==========================================

    public function categories(Request $request)
    {
        $search = $request->query('search');
        $categories = Category::withCount('products')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', "Categoría '{$request->name}' creada correctamente.");
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', "Categoría actualizada correctamente.");
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', 'No puedes eliminar una categoría que contiene productos.');
        }

        $category->delete();

        return back()->with('success', 'Categoría eliminada.');
    }

    // ==========================================
    // Módulo de Notificaciones
    // ==========================================

    public function markNotificationsRead()
    {
        \App\Models\AdminNotification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
