<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Mostrar formulario de checkout.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Tu carrito está vacío. Agrega productos antes de pagar.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = $subtotal > 150 ? 0 : 15.00;
        $total = $subtotal + $shipping;

        return view('checkout', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Procesar la orden de compra.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Tu carrito está vacío.');
        }

        // Validar datos de envío
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'card_number' => 'required|string|min:16',
            'expiry_date' => 'required|string|max:5',
            'cvv' => 'required|string|min:3|max:4',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = $subtotal > 150 ? 0 : 15.00;
        $total = $subtotal + $shipping;

        // Iniciar transacción de base de datos para garantizar consistencia
        DB::beginTransaction();

        try {
            // 1. Validar y restar stock de cada producto en el carrito
            foreach ($cart as $id => $details) {
                $product = Product::lockForUpdate()->find($id); // Bloqueo de fila para evitar condiciones de carrera en cluster
                
                if (!$product || $product->stock < $details['quantity']) {
                    throw new \Exception("Lo sentimos, no hay suficiente stock de '{$details['name']}' para procesar tu pedido.");
                }

                // Restar stock
                $product->decrement('stock', $details['quantity']);
            }

            // 2. Crear el Pedido (Order)
            $trackingNumber = 'ORDER-' . strtoupper(Str::random(10));
            
            $order = Order::create([
                'status' => 'processing',
                'total' => $total,
                'customer_name' => $request->input('customer_name'),
                'customer_email' => $request->input('customer_email'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'zip_code' => $request->input('zip_code'),
                'tracking_number' => $trackingNumber,
            ]);

            // 3. Crear los Detalles del Pedido (OrderItems)
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            // Confirmar transacción
            DB::commit();

            \App\Models\AdminNotification::create([
                'type' => 'order',
                'message' => 'Nuevo pedido #' . $trackingNumber . ' de $' . number_format($total, 2),
                'action_url' => route('admin.orders.index') // Asumiendo que crearé esta ruta
            ]);

            // Vaciar el carrito
            session()->forget('cart');

            return redirect()->route('checkout.success', $trackingNumber)
                ->with('success', '¡Pedido procesado con éxito!');

        } catch (\Exception $e) {
            // Deshacer cambios en caso de error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Mostrar pantalla de éxito.
     */
    public function success($tracking_number)
    {
        $order = Order::with('items.product')
            ->where('tracking_number', $tracking_number)
            ->firstOrFail();

        return view('success', compact('order'));
    }

    /**
     * Mostrar e imprimir factura en PDF/HTML.
     */
    public function invoice($tracking_number)
    {
        $order = Order::with('items.product')
            ->where('tracking_number', $tracking_number)
            ->firstOrFail();

        return view('invoice', compact('order'));
    }
}
