@extends('layouts.app')

@section('title', 'Aviso de Privacidad')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-slate-900/50 border border-slate-800 rounded-2xl p-8 md:p-12 backdrop-blur-sm shadow-xl">
        <h1 class="text-3xl font-extrabold text-white mb-6">Aviso de Privacidad</h1>
        
        <div class="space-y-6 text-slate-300 leading-relaxed">
            <p>
                En <strong>Ecommerce Elite</strong>, valoramos su privacidad y nos comprometemos a proteger sus datos personales. Este Aviso de Privacidad explica cómo recopilamos, usamos, divulgamos y salvaguardamos su información cuando visita nuestro sitio web o realiza una compra.
            </p>

            <h2 class="text-xl font-bold text-white mt-8">1. Información que Recopilamos</h2>
            <p>
                Recopilamos información personal que usted nos proporciona directamente al registrarse, realizar un pedido, suscribirse a nuestro boletín o contactarnos. Esto incluye nombre, dirección de correo electrónico, dirección de envío y detalles de pago. Utilizamos servicios de terceros seguros (como Clerk) para la autenticación y gestión de cuentas.
            </p>

            <h2 class="text-xl font-bold text-white mt-8">2. Uso de la Información</h2>
            <p>
                Utilizamos la información recopilada para:
            </p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Procesar y gestionar sus pedidos y pagos.</li>
                <li>Mantener y mejorar la seguridad de su cuenta.</li>
                <li>Comunicarnos con usted respecto a sus compras o cambios en nuestros servicios.</li>
                <li>Mejorar nuestra plataforma y experiencia de usuario.</li>
            </ul>

            <h2 class="text-xl font-bold text-white mt-8">3. Compartir su Información</h2>
            <p>
                No vendemos ni alquilamos su información personal a terceros. Podemos compartir su información con proveedores de servicios de confianza (por ejemplo, pasarelas de pago y servicios de envío) exclusivamente para facilitar nuestras operaciones.
            </p>

            <h2 class="text-xl font-bold text-white mt-8">4. Seguridad de los Datos</h2>
            <p>
                Implementamos medidas de seguridad técnicas y organizativas para proteger su información contra acceso no autorizado, alteración, divulgación o destrucción. Sin embargo, ningún sistema de transmisión por Internet es 100% seguro.
            </p>

            <h2 class="text-xl font-bold text-white mt-8">5. Sus Derechos</h2>
            <p>
                Usted tiene derecho a acceder, corregir o eliminar su información personal. Puede gestionar su cuenta a través de nuestro panel de usuario o contactándonos directamente.
            </p>

            <h2 class="text-xl font-bold text-white mt-8">6. Contacto</h2>
            <p>
                Si tiene alguna pregunta sobre este Aviso de Privacidad, por favor contáctenos a través de nuestro soporte técnico en la plataforma.
            </p>
            
            <p class="text-sm text-slate-500 mt-12">
                Última actualización: {{ now()->format('d/m/Y') }}
            </p>
        </div>
    </div>
</div>
@endsection
