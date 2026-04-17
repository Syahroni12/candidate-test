<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Layup;
use App\Models\Layer;

class LayerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $supplier;
    protected $layup;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->supplier = Supplier::create(['name' => 'Main Supplier']);
        $this->layup = $this->supplier->layups()->create(['name' => 'Primary Layup']);
    }

    public function test_user_can_view_layers_for_layup()
    {
        $this->layup->layers()->create([
            'layer_order' => 1,
            'thickness' => 10.5,
            'width' => 200,
            'angle' => 90,
        ]);

        $response = $this->get(route('layer.index', $this->layup->id));

        $response->assertStatus(200);
        $response->assertSee('10.5'); // check if thickness is displayed
        $response->assertSee('90'); // check if angle is displayed
    }

    public function test_user_can_create_layer_under_layup()
    {
        $response = $this->post(route('layer.store', $this->layup->id), [
            'layer_order' => 2,
            'thickness' => 15,
            'width' => 150,
            'angle' => 0,
        ]);

        $response->assertRedirect(route('layer.index', $this->layup->id));
        $this->assertDatabaseHas('layers', [
            'layup_id' => $this->layup->id,
            'layer_order' => 2,
            'thickness' => 15,
            'angle' => 0
        ]);
    }

    public function test_validation_fails_when_layer_thickness_is_negative()
    {
        $response = $this->post(route('layer.store', $this->layup->id), [
            'layer_order' => 1,
            'thickness' => -5, // Invalid, should be min:0
            'width' => 150,
            'angle' => 0,
        ]);

        $response->assertSessionHasErrors(['thickness']);
        $this->assertDatabaseCount('layers', 0);
    }

    public function test_user_can_update_layer()
    {
        $layer = $this->layup->layers()->create([
            'layer_order' => 1,
            'thickness' => 10,
            'width' => 100,
            'angle' => 90,
        ]);

        $response = $this->put(route('layer.update', $layer->id), [
            'layer_order' => 1,
            'thickness' => 12, // Updated thickness
            'width' => 100,
            'angle' => 90,
        ]);

        $response->assertRedirect(route('layer.index', $this->layup->id));
        $this->assertDatabaseHas('layers', [
            'id' => $layer->id,
            'thickness' => 12
        ]);
    }

    public function test_user_can_delete_layer()
    {
        $layer = $this->layup->layers()->create([
            'layer_order' => 1,
            'thickness' => 10,
            'width' => 100,
            'angle' => 90,
        ]);

        $response = $this->delete(route('layer.destroy', $layer->id));

        $response->assertRedirect(route('layer.index', $this->layup->id));
        $this->assertDatabaseMissing('layers', [
            'id' => $layer->id
        ]);
    }
}
