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
        $categories = Category::all();
        return view('services.index', compact('services', 'categories'));
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
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Service::with('category')->find($id);
        $categories = Category::all();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('services.getEditFormB', compact('data', 'categories'))->render()
        ), 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);
        $data->service_name = $request->service_name;
        $data->description = $request->description;
        $data->availability = $request->availability;
        $data->price = $request->price;
        $data->category_id = $request->category_id;
        $data->save();

        // return the category name as well so the frontend can update safely
        $categoryName = Category::find($request->category_id)->category_name;

        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Service data is up-to-date!',
            'category_name' => $categoryName
        ), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);
        
        if ($data) {
            // Delete pivot manually to avoid SQL constraints
            $data->transactions()->detach();
            
            $data->delete();
            return response()->json(array(
                'status' => 'oke',
                'msg' => 'Service data is removed !'
            ), 200);
        }

        return response()->json(array(
            'status' => 'error',
            'msg' => 'Service not found!'
        ), 404);
    }
    public function destroy(string $id)
    {
        //
    }
}
