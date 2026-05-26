<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori dari database untuk Combo Box
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'availability' => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
        ]);

        // Simpan data ke database menggunakan Eloquent
        Service::create([
            'service_name' => $request->service_name,
            'description'  => $request->description,
            'availability' => $request->availability,
            'price'        => $request->price,
            'category_id'  => $request->category_id,
        ]);

        // Redirect ke halaman index dengan flash message sukses
        return redirect()->route('services.index')
            ->with('success', 'Service berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
