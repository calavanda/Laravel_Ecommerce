<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar catálogo completo con filtros y buscador.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filtrar por búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrar por categoría
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();

        return view('catalog', compact('products', 'categories', 'featuredProducts'));
    }

    /**
     * Mostrar detalle de un producto específico.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
