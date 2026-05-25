<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Categorías
        $categories = [
            [
                'name' => 'Tecnología',
                'slug' => 'tecnologia',
                'products' => [
                    [
                        'name' => 'Auriculares Inalámbricos Pro',
                        'description' => 'Auriculares con cancelación de ruido activa, bluetooth 5.2 y hasta 30 horas de autonomía con estuche de carga inteligente.',
                        'price' => 129.99,
                        'stock' => 25,
                        'image_path' => 'tech-headphones',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Teclado Mecánico RGB',
                        'description' => 'Teclado mecánico con interruptores táctiles silenciosos, retroiluminación RGB configurable por tecla y diseño ergonómico de aluminio.',
                        'price' => 89.99,
                        'stock' => 15,
                        'image_path' => 'tech-keyboard',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Smartwatch Active Fit',
                        'description' => 'Reloj inteligente con monitor de ritmo cardíaco, GPS incorporado, resistencia al agua IP68 y pantalla AMOLED de alta resolución.',
                        'price' => 199.99,
                        'stock' => 30,
                        'image_path' => 'tech-watch',
                        'is_featured' => false,
                    ],
                    [
                        'name' => 'Cargador Solar Portátil',
                        'description' => 'Batería externa de 20,000mAh con panel de carga solar de alta eficiencia, carga rápida USB-C y linterna LED integrada.',
                        'price' => 45.50,
                        'stock' => 50,
                        'image_path' => 'tech-solar',
                        'is_featured' => false,
                    ],
                ]
            ],
            [
                'name' => 'Moda y Accesorios',
                'slug' => 'moda-accesorios',
                'products' => [
                    [
                        'name' => 'Mochila Explorer Impermeable',
                        'description' => 'Mochila de lona impermeable de alta calidad con compartimento acolchado para portátil de 15.6 pulgadas, perfecta para viajes o uso diario.',
                        'price' => 59.99,
                        'stock' => 40,
                        'image_path' => 'fashion-backpack',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Gafas de Sol Clasicas',
                        'description' => 'Gafas de sol con montura de acetato hecha a mano y lentes polarizados con protección UV400 completa.',
                        'price' => 34.99,
                        'stock' => 60,
                        'image_path' => 'fashion-glasses',
                        'is_featured' => false,
                    ],
                    [
                        'name' => 'Zapatillas Casual Air',
                        'description' => 'Zapatillas urbanas ultra cómodas con suela amortiguadora de aire y tejido transpirable. Estilo minimalista unisex.',
                        'price' => 79.90,
                        'stock' => 20,
                        'image_path' => 'fashion-shoes',
                        'is_featured' => true,
                    ],
                ]
            ],
            [
                'name' => 'Hogar y Oficina',
                'slug' => 'hogar-oficina',
                'products' => [
                    [
                        'name' => 'Cafetera de Goteo Programable',
                        'description' => 'Cafetera inteligente con temporizador programable de 24 horas, jarra de vidrio templado para 12 tazas y placa calefactora antiadherente.',
                        'price' => 49.99,
                        'stock' => 12,
                        'image_path' => 'home-coffee',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Lámpara de Escritorio Minimalista',
                        'description' => 'Lámpara LED inteligente con ajuste de brillo táctil continuo, 3 modos de temperatura de color y puerto de carga inalámbrica para móviles.',
                        'price' => 39.99,
                        'stock' => 18,
                        'image_path' => 'home-lamp',
                        'is_featured' => false,
                    ],
                    [
                        'name' => 'Organizador de Escritorio de Madera',
                        'description' => 'Organizador modular elegante hecho de madera de bambú sostenible con múltiples compartimentos para bolígrafos, notas y smartphone.',
                        'price' => 24.99,
                        'stock' => 35,
                        'image_path' => 'home-organizer',
                        'is_featured' => false,
                    ],
                ]
            ],
            [
                'name' => 'Deportes y Salud',
                'slug' => 'deportes-salud',
                'products' => [
                    [
                        'name' => 'Botella de Agua Térmica Pro',
                        'description' => 'Botella de acero inoxidable de doble pared aislada al vacío. Mantiene bebidas frías por 24 horas o calientes por 12 horas. Capacidad 750ml.',
                        'price' => 19.99,
                        'stock' => 80,
                        'image_path' => 'sport-bottle',
                        'is_featured' => false,
                    ],
                    [
                        'name' => 'Esterilla de Yoga Ecológica',
                        'description' => 'Esterilla antideslizante fabricada en material TPE ecológico, de 6mm de grosor para una perfecta amortiguación de las articulaciones.',
                        'price' => 29.99,
                        'stock' => 22,
                        'image_path' => 'sport-mat',
                        'is_featured' => true,
                    ],
                ]
            ],
        ];

        // 2. Insertar Categorías y Productos
        foreach ($categories as $catData) {
            $category = Category::create([
                'name' => $catData['name'],
                'slug' => $catData['slug'],
            ]);

            foreach ($catData['products'] as $prodData) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $prodData['name'],
                    'slug' => Str::slug($prodData['name']),
                    'description' => $prodData['description'],
                    'price' => $prodData['price'],
                    'stock' => $prodData['stock'],
                    'image_path' => $prodData['image_path'],
                    'is_featured' => $prodData['is_featured'],
                ]);
            }
        }
    }
}
