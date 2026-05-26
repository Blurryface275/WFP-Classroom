<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }
        else if(!$request->hasFile('image')){
            return redirect()->back()
                ->with('error', 'Tambahkan gambar untuk kategori!');
        }

        Category::create([
            'category_name' => $validated['category_name'],
            'image'         => $imagePath,
        ]);

        return redirect()->route('category.index')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $category->image; // keep existing image by default
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }
        else{ // drop error here
            return redirect()->route('category.index')
                ->with('error', 'Kategori gagal diperbarui!');
        }

        $category->update([
            'category_name' => $validated['category_name'],
            'image'         => $imagePath,
        ]);

        $category->save();

        return redirect()->route('category.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('category.index')
                ->with('success', 'Kategori berhasil dihapus!');
        }
        catch(\PDOException $e){
            $message = "Make sure there are no services in this category!";
            return redirect()->route('category.index')
                ->with('error', $message);
        }
    }

    public function showExpensiveServices(string $id) {}

    public function showInfo()
    {
        $highestServiceCategory = Category::withCount('services')
            ->orderByDesc('services_count')
            ->first();

        return response()->json(array(
            'status' => 'oke',
            'msg' => '<div class="alert alert-success">The category with the most services is: <b>' .
                $highestServiceCategory->category_name . '</b></div>'
        ), 200);
    }
}
