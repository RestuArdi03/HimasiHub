<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesan = Pesan::with('users')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        // Melewatkan data ke view backend/pesan/index.blade.php
        return view('backend.pesan.index', compact('pesan'));
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

        // dd($request->all());
        $request->validate([
            'subjek' => 'required|string',
            'pesan' => 'required|string|max:2000',
        ]);

        Pesan::create([
            'users_id' => auth()->id(),
            'subjek' => $request->subjek,
            'isi' => $request->pesan,
        ]);

        return back()->with('success', 'Pesan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesan $pesan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesan $pesan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesan $pesan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->route('backend.pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
