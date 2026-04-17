<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Layup;
use App\Models\Layer;
use Illuminate\Http\Request;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ImportExportController extends Controller
{
    public function export(Supplier $supplier)
    {
        // Eager load nested relationships
        $supplier->load('layups.layers');

        // Prepare the structure
        $data = [
            'supplier_id' => $supplier->id,
            'supplier_name' => $supplier->name,
            'layups' => $supplier->layups->map(function ($layup) {
                return [
                    'name' => $layup->name,
                    'layers' => $layup->layers->map(function ($layer) {
                        return [
                            'layer_order' => $layer->layer_order,
                            'thickness' => $layer->thickness,
                            'width' => $layer->width,
                            'angle' => $layer->angle,
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];

        // Format filename
        $fileName = 'supplier_' . $supplier->id . '_export.json';
        
        // Return JSON response triggering a download
        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function import(ImportRequest $request, Supplier $supplier)
    {
        // 2. Read JSON
        $file = $request->file('import_file');
        $content = file_get_contents($file->getRealPath());
        $data = json_decode($content, true);

        // Basic Structure Validation
        if (!$data || !isset($data['layups'])) {
            Alert::error('Invalid JSON', 'The uploaded file structure is invalid.');
            return redirect()->back();
        }

        $strategy = $request->conflict_strategy;
        
        // 3. Process the data
        DB::beginTransaction();
        try {
            foreach ($data['layups'] as $layupData) {
                // Determine Layup Conflict
                $existingLayup = Layup::where('supplier_id', $supplier->id)
                                      ->where('name', $layupData['name'])
                                      ->first();

                $targetLayup = null;

                if ($existingLayup) {
                    // Layup Conflict detected
                    if ($strategy === 'duplicate') {
                        // Duplicate Strategy: Create new with "(imported)" suffix
                        $newLayupName = $layupData['name'] . ' (imported)';
                        $targetLayup = Layup::create([
                            'supplier_id' => $supplier->id,
                            'name' => $newLayupName
                        ]);
                    } else if ($strategy === 'skip') {
                        // Skip Strategy: We treat it as same layup, but we don't modify the layup details itself.
                        // For layups, it only has 'name', so nothing to overwrite. Just map to existing.
                        $targetLayup = $existingLayup;
                    } else { 
                        // Overwrite Strategy: Same, map to existing.
                        $targetLayup = $existingLayup;
                    }
                } else {
                    // No conflict, safe to create
                    $targetLayup = Layup::create([
                        'supplier_id' => $supplier->id,
                        'name' => $layupData['name']
                    ]);
                }

                // Process Layers inside this Layup
                if (isset($layupData['layers']) && is_array($layupData['layers'])) {
                    foreach ($layupData['layers'] as $layerData) {
                        $existingLayer = $targetLayup->layers()->where('layer_order', $layerData['layer_order'])->first();

                        if ($existingLayer) {
                            // Layer Conflict detected (same layer order and related layup)
                            // Check if fields actually differ
                            $isConflict = (
                                $existingLayer->thickness != $layerData['thickness'] ||
                                $existingLayer->width != $layerData['width'] ||
                                $existingLayer->angle != $layerData['angle']
                            );

                            if ($isConflict) {
                                if ($strategy === 'overwrite') {
                                    $existingLayer->update([
                                        'thickness' => $layerData['thickness'],
                                        'width' => $layerData['width'],
                                        'angle' => $layerData['angle'],
                                    ]);
                                }
                                // If duplicate strategy: we created a new Layup, thus $existingLayer would be NULL earlier,
                                // meaning the layer is freshly created in the block below.
                                // If skip strategy: we do nothing.
                            }
                        } else {
                            // Layup doesn't have this layer order yet, safe to create
                            $targetLayup->layers()->create([
                                'layer_order' => $layerData['layer_order'],
                                'thickness' => $layerData['thickness'],
                                'width' => $layerData['width'],
                                'angle' => $layerData['angle'],
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            Alert::success('Import Successful', "The data was imported using the '$strategy' strategy.");
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Import Failed', 'An error occurred during import: ' . $e->getMessage());
        }

        return redirect()->route('layup.index', $supplier->id);
    }
}
