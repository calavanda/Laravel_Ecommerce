<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Mostrar la vista del carrito.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = $subtotal > 0 ? ($subtotal > 150 ? 0 : 15.00) : 0;
        $total = $subtotal + $shipping;

        return view('cart', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Añadir un producto al carrito.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        // Validar stock disponible
        if (!$product->hasStock($quantity)) {
            return redirect()->back()->with('error', "No hay suficiente stock de {$product->name}.");
        }

        $cart = session()->get('cart', []);

        // Si el producto ya está en el carrito, sumar la cantidad
        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            
            if (!$product->hasStock($newQuantity)) {
                return redirect()->back()->with('error', "No hay suficiente stock disponible.");
            }
            
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            // Añadir nuevo producto
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image_path" => $product->image_path,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', "{$product->name} añadido al carrito.");
    }

    /**
     * Actualizar la cantidad de un producto en el carrito.
     */
    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        
        if ($quantity <= 0) {
            return $this->remove($id);
        }

        $product = Product::findOrFail($id);
        
        if (!$product->hasStock($quantity)) {
            return redirect()->back()->with('error', "No hay suficiente stock para la cantidad solicitada.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', "Carrito actualizado.");
        }

        return redirect()->route('cart.index')->with('error', "El producto no está en el carrito.");
    }

    /**
     * Eliminar un producto del carrito.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', "Producto removido del carrito.");
        }

        return redirect()->route('cart.index')->with('error', "El producto no estaba en tu carrito.");
    }

    /**
     * Vaciar por completo el carrito.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', "Tu carrito ha sido vaciado.");
    }
}
