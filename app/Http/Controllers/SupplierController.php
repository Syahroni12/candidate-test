<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // 1. Query dasar
        $query = Supplier::withCount('layups')->orderBy('created_at', 'desc');

        // 2. Logika Pencarian (Backend Search)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            // Kita bungkus pakai where closure agar 'orWhere' tidak mengacaukan query lain
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }

        // 3. Paginasi (tambahkan withQueryString agar parameter ?search=... terbawa saat pindah halaman)
        $suppliers = $query->paginate(5)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        // Simpan ke database
        Supplier::create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Supplier created successfully.');
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validasi->fails()) {
            Alert::error('Validation Error', 'Please correct the errors in the form.');
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        $supplier->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Supplier updated successfully.');
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // dd($supplier);

        $supplier->delete();

        Alert::success('Deleted', 'Supplier deleted successfully.');
        return redirect()->route('supplier.index');
    }
}
