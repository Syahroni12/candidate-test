<?php

namespace App\Http\Controllers;

use App\Models\Layer;
use App\Models\Layup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    public function store(Request $request, Layup $layup)
    {
        $validasi = Validator::make($request->all(), [
            'layer_order' => 'required|integer|min:1',
            'thickness'   => 'required|numeric|min:0',
            'width'       => 'required|numeric|min:0',
            'angle'       => 'required|numeric',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

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
    public function update(Request $request, Layer $layer)
    {
        $validasi = Validator::make($request->all(), [
            'layer_order' => 'required|integer|min:1',
            'thickness'   => 'required|numeric|min:0',
            'width'       => 'required|numeric|min:0',
            'angle'       => 'required|numeric',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

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
