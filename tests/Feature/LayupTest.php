<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Layup;

class LayupTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $supplier;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // We almost always need a supplier to nest layups under
        $this->supplier = Supplier::create(['name' => 'Main Supplier']);
    }

    public function test_user_can_view_layups_for_supplier()
    {
        $layup1 = $this->supplier->layups()->create(['name' => 'Roof Layup']);
        $layup2 = $this->supplier->layups()->create(['name' => 'Floor Layup']);

        $response = $this->get(route('layup.index', $this->supplier->id));

        $response->assertStatus(200);
        $response->assertSee('Roof Layup');
        $response->assertSee('Floor Layup');
    }

    public function test_user_can_create_layup_under_supplier()
    {
        $response = $this->post(route('layup.store', $this->supplier->id), [
            'name' => 'Wall Layup'
        ]);

        $response->assertRedirect(route('layup.index', $this->supplier->id));
        $this->assertDatabaseHas('layups', [
            'supplier_id' => $this->supplier->id,
            'name' => 'Wall Layup'
        ]);
    }

    public function test_validation_fails_when_creating_layup_without_name()
    {
        $response = $this->post(route('layup.store', $this->supplier->id), [
            'name' => '' // Empty missing name
        ]);

        // FormRequest redirects back and error bag gets attached
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('layups', 0);
    }

    public function test_user_can_update_layup()
    {
        $layup = $this->supplier->layups()->create(['name' => 'Old Layup Name']);

        $response = $this->put(route('layup.update', $layup->id), [
            'name' => 'Updated Layup Name'
        ]);

        $response->assertRedirect(route('layup.index', $this->supplier->id));
        $this->assertDatabaseHas('layups', [
            'id' => $layup->id,
            'name' => 'Updated Layup Name'
        ]);
    }

    public function test_user_can_delete_layup()
    {
        $layup = $this->supplier->layups()->create(['name' => 'To Be Deleted']);

        $response = $this->delete(route('layup.destroy', $layup->id));

        $response->assertRedirect(route('layup.index', $this->supplier->id));
        $this->assertDatabaseMissing('layups', [
            'id' => $layup->id
        ]);
    }
}
