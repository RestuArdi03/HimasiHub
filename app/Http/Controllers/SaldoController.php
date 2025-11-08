<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaldoRequest;
use App\Http\Requests\UpdateSaldoRequest;
use App\Models\Saldo;

class SaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Saldo::class);
        $saldo = Saldo::with(['user'])->orderBy('nama')->paginate(15);
        return view('backend.saldo.index', compact('saldo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Saldo::class);
        return view('backend.saldo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaldoRequest $request)
    {
        $this->authorize('create', Saldo::class);
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        Saldo::create($validated);

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Saldo $saldo)
    {
        $this->authorize('view', $saldo);
        $saldo->load([
            'user',
            'transactions',
        ]);
        return view('backend.saldo.show', compact('saldo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saldo $saldo)
    {
        $this->authorize('update', $saldo);
        return view('backend.saldo.edit', [
            'saldo' => $saldo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaldoRequest $request, Saldo $saldo)
    {
        $this->authorize('update', $saldo);
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $saldo->update($validated);

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saldo $saldo)
    {
        $this->authorize('delete', $saldo);
        $saldo->delete();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dihapus.');
    }

    // Restore
    public function restore(Saldo $saldo)
    {        $this->authorize('restore', $saldo);
        $saldo->restore();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dipulihkan.');
    }

    // Force Delete
    public function forceDelete(Saldo $saldo)
    {
        $this->authorize('forceDelete', $saldo);
        $saldo->forceDelete();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dihapus permanen.');
    }

    // Tempat sampah
    public function trash()
    {        $this->authorize('viewAny', Saldo::class);
        $saldo = Saldo::onlyTrashed()->with(['user'])->orderBy('nama')->paginate(15);
        return view('backend.saldo.trash', compact('saldo'));
    }


}
