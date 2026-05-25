<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear una categoría y un producto de prueba
        $this->category = Category::create([
            'name' => 'Tech Test',
            'slug' => 'tech-test',
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'A wonderful test description for ecommerce testing.',
            'price' => 99.99,
            'stock' => 10,
            'image_path' => 'tech-headphones',
            'is_featured' => true,
        ]);
    }

    /**
     * Test: Validar que el catálogo de productos responde correctamente.
     */
    public function test_catalog_page_loads_successfully(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertSee('Tech Test');
    }

    /**
     * Test: Validar que la página de detalles responde correctamente.
     */
    public function test_product_detail_page_loads_successfully(): void
    {
        $response = $this->get(route('products.show', $this->product->slug));

        $response->assertStatus(200);
        $response->assertSee($this->product->name);
        $response->assertSee($this->product->description);
    }

    /**
     * Test: Validar la adición de artículos al carrito.
     */
    public function test_can_add_product_to_cart(): void
    {
        $response = $this->post(route('cart.add', $this->product->id), [
            'quantity' => 2
        ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertEquals(2, session('cart')[$this->product->id]['quantity']);
    }

    /**
     * Test: Validar que el checkout de compras procesa correctamente y reduce stock.
     */
    public function test_checkout_creates_order_and_reduces_stock(): void
    {
        // 1. Agregar al carrito
        $this->post(route('cart.add', $this->product->id), ['quantity' => 3]);

        // 2. Procesar el checkout
        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'address' => '123 Test Street',
            'city' => 'Test City',
            'zip_code' => '12345',
        ]);

        // 3. Validar redirección de éxito
        $order = Order::first();
        $this->assertNotNull($order);
        
        $response->assertRedirect(route('checkout.success', $order->tracking_number));
        
        // 4. Validar reducción de stock (10 inicial - 3 comprados = 7 restante)
        $this->product->refresh();
        $this->assertEquals(7, $this->product->stock);
        
        // 5. Validar que el carrito está vacío en la sesión
        $this->assertEmpty(session('cart'));
    }

    /**
     * Test: Validar que el panel administrativo carga correctamente.
     */
    public function test_admin_dashboard_loads_successfully(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Panel Administrativo');
    }
}
