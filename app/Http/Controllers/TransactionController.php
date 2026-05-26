<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('services')->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua service dari database untuk Combo Box
        $services = Service::all();
        return view('transactions.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'transaction_date' => 'required|date',
            'status'           => 'required|string|max:100',
            'total_price'      => 'required|numeric|min:0',
            'payment_method'   => 'required|string|max:100',
            'service_id'       => 'required|exists:services,id',
        ]);

        // Simpan data Transaksi baru ke database
        $transaction = Transaction::create([
            'user_id'          => 1, // default user, bisa diubah sesuai auth
            'transaction_date' => $request->transaction_date,
            'status'           => $request->status,
            'total_price'      => $request->total_price,
            'payment_method'   => $request->payment_method,
            'service_id'       => $request->service_id,
        ]);

        // Many-to-Many: hubungkan Transaction dengan Service menggunakan attach()
        $transaction->services()->attach($request->service_id);

        // Redirect ke halaman index dengan flash message sukses
        return redirect()->route('transaction.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the existing resource.
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
