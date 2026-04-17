<?php

namespace App\Http\Controllers;

use App\Models\Layup;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LayupController extends Controller
{
    /**
     * Display a listing of layups for a supplier.
     */
    public function index(Supplier $supplier)
    {
        return view('layup.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new layup.
     */
    public function create(Supplier $supplier)
    {
        return view('layup.create', compact('supplier'));
    }

    /**
     * Store a newly created layup in storage.
     */
    public function store(Request $request, Supplier $supplier)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $supplier->layups()->create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Layup created successfully.');
        return redirect()->route('layup.index', $supplier->id);
    }

    /**
     * Show the form for editing the specified layup.
     */
    public function edit(Layup $layup)
    {
        $supplier = $layup->supplier;
        return view('layup.edit', compact('layup', 'supplier'));
    }

    /**
     * Update the specified layup in storage.
     */
    public function update(Request $request, Layup $layup)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $layup->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Layup updated successfully.');
        return redirect()->route('layup.index', $layup->supplier_id);
    }

    /**
     * Remove the specified layup from storage.
     */
    public function destroy(Layup $layup)
    {
        $supplier_id = $layup->supplier_id;
        $layup->delete();

        Alert::success('Deleted', 'Layup deleted successfully.');
        return redirect()->route('layup.index', $supplier_id);
    }
}
