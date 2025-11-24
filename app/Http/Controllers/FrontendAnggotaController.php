<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Storage;

class FrontendAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::select('anggota.*')
        // Lakukan join ke tabel jabatan
        ->join('jabatan', 'anggota.jabatan_id', '=', 'jabatan.id') 
        // Urutkan berdasarkan kolom 'kode_jabatan' di tabel jabatan
        ->orderBy('jabatan.kode_jabatan', 'asc') 
        ->get();
        return view('frontend.anggota.index', compact('anggota'));
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
        //
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
