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
        $services = Service::all();
        return view('transactions.index', compact('transactions', 'services'));
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
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Transaction::with('services')->find($id);
        $services = Service::all();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('transactions.getEditFormB', compact('data', 'services'))->render()
        ), 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Transaction::find($id);
        $data->transaction_date = $request->transaction_date;
        $data->status = $request->status;
        $data->total_price = $request->total_price;
        $data->payment_method = $request->payment_method;
        $data->save();

        if ($request->has('service_id') && !empty($request->service_id)) {
            $data->services()->sync([$request->service_id]);
        }

        // Fetch reloaded data to send back the services badge HTML
        $data->load('services');
        $servicesHtml = '';
        foreach ($data->services as $s) {
            $servicesHtml .= '<span class="badge bg-info text-dark me-1">' . $s->service_name . '</span>';
        }

        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Transaction data is up-to-date!',
            'services_html' => $servicesHtml
        ), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Transaction::find($id);
        $data->services()->detach();
        $data->delete();
        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Transaction data is removed !'
        ), 200);
    }
}
