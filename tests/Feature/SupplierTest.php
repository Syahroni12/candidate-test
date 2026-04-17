<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Supplier;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an auth user to bypass auth middleware
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_user_can_view_suppliers_list()
    {
        Supplier::create(['name' => 'Timber Co A']);
        Supplier::create(['name' => 'Lumber Inc B']);

        $response = $this->get(route('supplier.index'));

        $response->assertStatus(200);
        $response->assertSee('Timber Co A');
        $response->assertSee('Lumber Inc B');
    }

    public function test_user_can_create_supplier()
    {
        $response = $this->post(route('supplier.store'), [
            'name' => 'Premium Wood Supplier'
        ]);

        $response->assertRedirect(route('supplier.index'));
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Premium Wood Supplier'
        ]);
    }

    public function test_user_can_update_supplier()
    {
        $supplier = Supplier::create(['name' => 'Old Name']);

        $response = $this->put(route('supplier.update', $supplier->id), [
            'name' => 'Updated Name'
        ]);

        $response->assertRedirect(route('supplier.index'));
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_user_can_delete_supplier()
    {
        $supplier = Supplier::create(['name' => 'To Be Deleted']);

        // Since the standard resource creates a route named 'supplier.destroy' for DELETE requests
        $response = $this->delete(route('supplier.destroy', $supplier->id));

        $response->assertRedirect(route('supplier.index'));
        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id
        ]);
    }
}
