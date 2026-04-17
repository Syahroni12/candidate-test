<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Layup;

class ImportExportTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $supplier;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->supplier = Supplier::create(['name' => 'Import Target Supplier']);
    }

    public function test_user_can_export_supplier_data_as_json()
    {
        $layup = $this->supplier->layups()->create(['name' => 'Export Layup']);
        $layup->layers()->create([
            'layer_order' => 1,
            'thickness' => 15,
            'width' => 100,
            'angle' => 0,
        ]);

        $response = $this->get(route('supplier.export', $this->supplier->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
        
        // Assert json structure
        $response->assertJson([
            'supplier_name' => 'Import Target Supplier',
            'layups' => [
                [
                    'name' => 'Export Layup',
                    'layers' => [
                        [
                            'layer_order' => 1,
                            'thickness' => 15,
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_import_with_overwrite_strategy()
    {
        // 1. Setup existing conflicting data
        $existingLayup = $this->supplier->layups()->create(['name' => 'Test Layup']);
        $existingLayup->layers()->create([
            'layer_order' => 1,
            'thickness' => 10, // Older thickness
            'width' => 100,
            'angle' => 90,
        ]);

        // 2. Prepare JSON with new thickness (20)
        $jsonPayload = [
            'layups' => [
                [
                    'name' => 'Test Layup',
                    'layers' => [
                        [
                            'layer_order' => 1,
                            'thickness' => 20, // New thickness
                            'width' => 100,
                            'angle' => 90,
                        ]
                    ]
                ]
            ]
        ];

        $file = UploadedFile::fake()->createWithContent('import.json', json_encode($jsonPayload));

        $response = $this->post(route('supplier.import', $this->supplier->id), [
            'import_file' => $file,
            'conflict_strategy' => 'overwrite'
        ]);

        $response->assertRedirect();
        
        // Assert thickness was overwritten to 20
        $this->assertDatabaseHas('layers', [
            'layup_id' => $existingLayup->id,
            'layer_order' => 1,
            'thickness' => 20
        ]);
        
        // Ensure no duplicated layups
        $this->assertDatabaseCount('layups', 1);
    }

    public function test_import_with_skip_strategy()
    {
        // 1. Setup existing conflicting data
        $existingLayup = $this->supplier->layups()->create(['name' => 'Test Layup']);
        $existingLayup->layers()->create([
            'layer_order' => 1,
            'thickness' => 10, // Older thickness
            'width' => 100,
            'angle' => 90,
        ]);

        // 2. Prepare JSON with new thickness (20)
        $jsonPayload = [
            'layups' => [
                [
                    'name' => 'Test Layup',
                    'layers' => [
                        [
                            'layer_order' => 1,
                            'thickness' => 20, // New conflicting thickness
                            'width' => 100,
                            'angle' => 90,
                        ]
                    ]
                ]
            ]
        ];

        $file = UploadedFile::fake()->createWithContent('import.json', json_encode($jsonPayload));

        $response = $this->post(route('supplier.import', $this->supplier->id), [
            'import_file' => $file,
            'conflict_strategy' => 'skip'
        ]);

        $response->assertRedirect();
        
        // Assert thickness remains 10 (skipped conflict)
        $this->assertDatabaseHas('layers', [
            'layup_id' => $existingLayup->id,
            'layer_order' => 1,
            'thickness' => 10
        ]);
    }

    public function test_import_with_duplicate_strategy()
    {
        // 1. Setup existing conflicting data
        $existingLayup = $this->supplier->layups()->create(['name' => 'Test Layup']);
        
        // 2. Prepare JSON with duplicate target
        $jsonPayload = [
            'layups' => [
                [
                    'name' => 'Test Layup',
                    'layers' => []
                ]
            ]
        ];

        $file = UploadedFile::fake()->createWithContent('import.json', json_encode($jsonPayload));

        $response = $this->post(route('supplier.import', $this->supplier->id), [
            'import_file' => $file,
            'conflict_strategy' => 'duplicate'
        ]);

        $response->assertRedirect();
        
        // Should have original layup
        $this->assertDatabaseHas('layups', [
            'name' => 'Test Layup'
        ]);

        // Should have a new duplicated layup
        $this->assertDatabaseHas('layups', [
            'name' => 'Test Layup (imported)'
        ]);
        
        // Total 2 layups now
        $this->assertDatabaseCount('layups', 2);
    }
}
