<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontenRequest;
use App\Http\Requests\UpdateKontenRequest;
use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Konten::class);
        $konten = Konten::with('user')->latest()->paginate(10);
        // Anda perlu membuat view: resources/views/backend/konten/index.blade.php
        return view('backend.konten.index', compact('konten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Konten::class);
        // Anda perlu membuat view: resources/views/backend/konten/create.blade.php
        return view('backend.konten.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKontenRequest $request)
    {
        $this->authorize('create', Konten::class);
        $validated = $request->validated();

        $slug = Str::slug($validated['judul'], '-');

        $path = $request->file('gambar')->store('public/konten');

        Konten::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'gambar' => $path,
            'deskripsi' => $validated['deskripsi'],
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('backend.konten.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konten $konten)
    {
        $this->authorize('view', $konten);
        $konten->load('user','komen');
        return view('backend.konten.show', compact('konten'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konten $konten)
    {
        $this->authorize('update', $konten);
        // Anda perlu membuat view: resources/views/backend/konten/edit.blade.php
        return view('backend.konten.edit', compact('konten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKontenRequest $request, Konten $konten)
    {
        $this->authorize('update', $konten);
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['judul'], '-');

        $path = $konten->gambar;
        if ($request->hasFile('gambar')) {
            Storage::delete($konten->gambar);
            $path = $request->file('gambar')->store('public/konten');
            $validated['gambar'] = $path;
        } else {
            $validated['gambar'] = $path;
        }

        $konten->update($validated);

        return redirect()->route('backend.konten.index')->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konten $konten)
    {
        $this->authorize('delete', $konten);
        Storage::delete($konten->gambar);
        $konten->delete();
        return redirect()->route('backend.konten.index')->with('success', 'Konten berhasil dihapus.');
    }
}
