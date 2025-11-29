<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use App\Models\Konten;
use Illuminate\Http\Request;

class FrontendKomenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Konten $konten)
    {
        $request->validate([
            'isi' => 'required|string|max:2000',
        ]);

        $isiKomen = [
            'users_id' => auth()->id(),
            'isi' => $request->isi,
            'konten_id' => $request->konten_id,
        ];
        // dd($isiKomen);
        Komen::create($isiKomen);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Komen $komen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Komen $komen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komen $komen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komen $komen)
    {
        //
    }
}
