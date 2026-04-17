<?php

namespace App\Http\Controllers;

use App\Models\Layer;
use App\Models\Layup;
use Illuminate\Http\Request;
use App\Http\Requests\LayerRequest;
use RealRashid\SweetAlert\Facades\Alert;

class LayerController extends Controller
{
    /**
     * Display a listing of layers for a layup.
     */
    public function index(Layup $layup)
    {
        $supplier = $layup->supplier;
        return view('layer.index', compact('layup', 'supplier'));
    }

    /**
     * Show the form for creating a new layer.
     */
    public function create(Layup $layup)
    {
        $supplier = $layup->supplier;
        return view('layer.create', compact('layup', 'supplier'));
    }

    /**
     * Store a newly created layer in storage.
     */
    public function store(LayerRequest $request, Layup $layup)
    {
        $layup->layers()->create([
            'layer_order' => $request->layer_order,
            'thickness'   => $request->thickness,
            'width'       => $request->width,
            'angle'       => $request->angle,
        ]);

        Alert::success('Success', 'Layer created successfully.');
        return redirect()->route('layer.index', $layup->id);
    }

    /**
     * Show the form for editing the specified layer.
     */
    public function edit(Layer $layer)
    {
        $layup    = $layer->layup;
        $supplier = $layup->supplier;
        return view('layer.edit', compact('layer', 'layup', 'supplier'));
    }

    /**
     * Update the specified layer in storage.
     */
    public function update(LayerRequest $request, Layer $layer)
    {
        $layer->update([
            'layer_order' => $request->layer_order,
            'thickness'   => $request->thickness,
            'width'       => $request->width,
            'angle'       => $request->angle,
        ]);

        Alert::success('Success', 'Layer updated successfully.');
        return redirect()->route('layer.index', $layer->layup_id);
    }

    /**
     * Remove the specified layer from storage.
     */
    public function destroy(Layer $layer)
    {
        $layup_id = $layer->layup_id;
        $layer->delete();

        Alert::success('Deleted', 'Layer deleted successfully.');
        return redirect()->route('layer.index', $layup_id);
    }
}
