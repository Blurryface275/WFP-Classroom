<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $allDoctors = DB::table('doctors')->get();
        return view('doctors.index', ['doctors' => $allDoctors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'specialist' => 'required|string',
            'gender' => 'required|string',
        ]);

        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'specialist' => $request->specialist,
            'gender' => $request->gender,
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
        ]);

        return redirect()->route('doctor.index')->with('success', 'Doctor di tambahkan!');
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Doctor::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('doctors.getEditFormB', compact('data'))->render()
        ), 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Doctor::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->description = $request->description;
        $data->specialist = $request->specialist;
        $data->gender = $request->gender;
        $data->save();

        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Doctor data is up-to-date!'
        ), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Doctor::find($id);
        $data->delete();
        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Doctor data is removed !'
        ), 200);
    }
}
