<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Pago - {{ $order->tracking_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background-color: white; color: black; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 p-8 font-sans">
    
    <div class="max-w-3xl mx-auto bg-white p-10 shadow-xl rounded-xl border border-slate-200">
        <!-- Header -->
        <div class="flex justify-between items-start border-b border-slate-200 pb-6 mb-6">
            <div>
                <h1 class="text-3xl font-black text-indigo-600 tracking-tight">ELITESHOP</h1>
                <p class="text-sm text-slate-500 mt-1">Tu tienda de tecnología y más</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-slate-800">FACTURA</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Nº {{ $order->tracking_number }}</p>
                <p class="text-sm text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Facturado a:</h3>
                <p class="font-bold text-slate-800">{{ $order->customer_name }}</p>
                <p class="text-sm text-slate-600">{{ $order->customer_email }}</p>
                <p class="text-sm text-slate-600">{{ $order->address }}</p>
                <p class="text-sm text-slate-600">{{ $order->city }}, {{ $order->zip_code }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Detalles del Pedido:</h3>
                <p class="text-sm text-slate-600"><span class="font-bold">Estado:</span> {{ ucfirst($order->status) }}</p>
                <p class="text-sm text-slate-600"><span class="font-bold">Método de Pago:</span> Tarjeta de Crédito (Simulado)</p>
            </div>
        </div>

        <!-- Tabla -->
        <table class="w-full text-left border-collapse mb-8">
            <thead>
                <tr class="bg-slate-50 border-y border-slate-200">
                    <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Descripción</th>
                    <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Cant.</th>
                    <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Precio Unit.</th>
                    <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @php $subtotal = 0; @endphp
                @foreach($order->items as $item)
                    @php 
                        $itemTotal = $item->quantity * $item->price;
                        $subtotal += $itemTotal;
                    @endphp
                    <tr>
                        <td class="py-4 px-4 text-sm font-medium text-slate-800">{{ $item->product->name }}</td>
                        <td class="py-4 px-4 text-sm text-slate-600 text-center">{{ $item->quantity }}</td>
                        <td class="py-4 px-4 text-sm text-slate-600 text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="py-4 px-4 text-sm font-bold text-slate-800 text-right">${{ number_format($itemTotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="flex justify-end">
            <div class="w-1/2 space-y-3">
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                @php $shipping = $subtotal > 150 ? 0 : 15.00; @endphp
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Costo de Envío:</span>
                    <span>{{ $shipping == 0 ? 'Gratis' : '$' . number_format($shipping, 2) }}</span>
                </div>
                <div class="border-t border-slate-200 pt-3 flex justify-between items-center">
                    <span class="text-base font-bold text-slate-800">Total:</span>
                    <span class="text-2xl font-black text-indigo-600">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center text-xs text-slate-400">
            <p>Gracias por tu compra en EliteShop.</p>
            <p>Esta factura ha sido generada electrónicamente y es válida sin firma ni sello.</p>
        </div>
    </div>

    <!-- Botones Flotantes (No imprimibles) -->
    <div class="fixed bottom-8 right-8 flex gap-4 no-print">
        <a href="{{ route('products.index') }}" class="px-6 py-3 bg-slate-800 text-white font-bold rounded-xl shadow-lg hover:bg-slate-700 transition">Volver a la Tienda</a>
        <button onclick="window.print()" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Imprimir Factura
        </button>
    </div>

    <script>
        // Imprimir automáticamente al cargar (opcional, pero útil)
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
