<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaldoRequest;
use App\Http\Requests\UpdateSaldoRequest;
use App\Models\Saldo;
use App\Models\User;

class SaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Saldo::class);
        $saldos = Saldo::with(['user'])->orderBy('nama')->paginate(15);
        $totalSaldo = Saldo::sum('balance');

        // Mengambil data bendahara. Asumsi hanya ada satu bendahara.
        $bendahara = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'Bendahara');
        })->first();

        return view('backend.saldo.index', [
            'saldos' => $saldos,
            'totalSaldo' => $totalSaldo,
            'bendahara' => $bendahara,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Saldo::class); // This is correct for creating a new resource
        return view('backend.saldo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaldoRequest $request)
    {
        $this->authorize('create', Saldo::class); // This is correct for storing a new resource
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $saldo = Saldo::create($validated);

        // Membuat transaksi pertama sebagai "Saldo Awal"
        $saldo->transactions()->create([
            'debit' => $saldo->balance,
            'saldo_akhir' => $saldo->balance,
            'keterangan' => 'Saldo Awal',
            'users_id' => $validated['user_id'],
        ]);

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Saldo $saldo)
    {
        $this->authorize('view', $saldo); // This is correct for viewing a specific resource

        // Jika saldo adalah 'Kas', alihkan ke halaman laporan kas khusus
        if ($saldo->nama === 'Kas') {
            return redirect()->route('backend.kas.index', ['saldo' => $saldo->id]);
        }

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
        $this->authorize('update', $saldo); // This is correct for editing a specific resource
        return view('backend.saldo.edit', [
            'saldo' => $saldo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaldoRequest $request, Saldo $saldo)
    {
        $this->authorize('update', $saldo); // This is correct for updating a specific resource
        // Validated request hanya akan berisi 'nama'
        $validated = $request->validated();
        $saldo->update($validated);

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saldo $saldo)
    {
        $this->authorize('delete', $saldo); // This is correct for soft deleting a specific resource
        $saldo->delete();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dihapus.');
    }

    // Restore
    public function restore(Saldo $saldo) // The $saldo parameter here is implicitly a trashed model
    {
        $this->authorize('restore', $saldo); // This is correct for restoring a specific resource
        $saldo->restore();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dipulihkan.');
    }

    // Force Delete
    public function forceDelete(Saldo $saldo)
    { // The $saldo parameter here is implicitly a trashed model
        $this->authorize('forceDelete', $saldo);
        $saldo->forceDelete();

        return redirect()->route('backend.saldo.index')->with('success', 'Saldo berhasil dihapus permanen.');
    }

    // Tempat sampah
    public function trash()
    {
        $this->authorize('viewAny', Saldo::class); // This is correct for viewing trashed resources
        $saldo = Saldo::onlyTrashed()->with(['user'])->orderBy('nama')->paginate(15);
        return view('backend.saldo.trash', compact('saldo'));
    }


}
