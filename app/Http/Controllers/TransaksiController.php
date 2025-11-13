<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Transaksi::class);
        $saldo_id = $request->query('saldo_id');
        $saldo = Saldo::findOrFail($saldo_id);

        return view('backend.transaksi.create', compact('saldo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        $this->authorize('create', Transaksi::class);
        $validated = $request->validated();

        $saldo = Saldo::findOrFail($validated['saldo_id']);

        DB::transaction(function () use ($validated, $saldo, $request) {
            $data = [
                'saldo_id' => $saldo->id,
                'users_id' => auth()->id(),
                'keterangan' => $validated['keterangan'],
                'debit' => $validated['jenis_transaksi'] == 'debit' ? $validated['jumlah'] : 0,
                'kredit' => $validated['jenis_transaksi'] == 'kredit' ? $validated['jumlah'] : 0,
            ];

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('transaksi_images', 'public');
            }

            // Buat transaksi tanpa saldo_akhir terlebih dahulu
            Transaksi::create($data);

            // Hitung ulang semua saldo
            $this->recalculateSaldo($saldo);
        });

        return redirect()->route('backend.saldo.show', $saldo->id)->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $this->authorize('update', $transaksi);
        $transaksi->load('saldo');
        return view('backend.transaksi.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        $this->authorize('update', $transaksi);
        $validated = $request->validated();
        $saldo = $transaksi->saldo;

        DB::transaction(function () use ($validated, $transaksi, $saldo, $request) {
            $data = [
                'keterangan' => $validated['keterangan'],
                'debit' => $validated['jenis_transaksi'] == 'debit' ? $validated['jumlah'] : 0,
                'kredit' => $validated['jenis_transaksi'] == 'kredit' ? $validated['jumlah'] : 0,
            ];

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($transaksi->gambar) {
                    Storage::disk('public')->delete($transaksi->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('transaksi_images', 'public');
            }

            $transaksi->update($data);

            // Hitung ulang semua saldo
            $this->recalculateSaldo($saldo);
        });

        return redirect()->route('backend.saldo.show', $saldo->id)->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $this->authorize('delete', $transaksi);
        $saldo = $transaksi->saldo;

        DB::transaction(function () use ($transaksi, $saldo) {
            $transaksi->delete(); // Soft delete

            // Hitung ulang semua saldo
            $this->recalculateSaldo($saldo);
        });

        return redirect()->route('backend.saldo.show', $saldo->id)->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function trash(Saldo $saldo)
    {
        // Menggunakan policy dari Saldo untuk mengecek apakah user boleh melihat detail saldo ini
        $this->authorize('view', $saldo);

        $trashedTransactions = $saldo->transactions()
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('backend.transaksi.trash', compact('saldo', 'trashedTransactions'));
    }

    /**
     * Restore a soft-deleted transaction.
     */
    public function restore($id)
    {
        $transaksi = Transaksi::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $transaksi);
        $saldo = $transaksi->saldo;

        DB::transaction(function () use ($transaksi, $saldo) {
            $transaksi->restore();
            $this->recalculateSaldo($saldo);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dipulihkan.');
    }

    /**
     * Permanently delete a transaction.
     */
    public function forceDelete($id)
    {
        $transaksi = Transaksi::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $transaksi);

        // Hapus gambar jika ada sebelum force delete
        if ($transaksi->gambar) {
            Storage::disk('public')->delete($transaksi->gambar);
        }

        // Tidak perlu recalculate karena transaksi sudah tidak ada (soft deleted)
        // Cukup hapus permanen dari database
        $transaksi->forceDelete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus permanen.');
    }

    /**
     * Recalculate all transaction balances for a given Saldo.
     * This method should be called within a DB::transaction.
     *
     * @param Saldo $saldo
     */
    private function recalculateSaldo(Saldo $saldo)
    {
        // Kunci baris saldo untuk mencegah race condition
        $saldo = Saldo::lockForUpdate()->find($saldo->id);

        // Ambil semua transaksi yang relevan (tidak termasuk yang di-soft-delete)
        // Urutkan berdasarkan tanggal dibuat, lalu ID untuk konsistensi
        $transactions = $saldo->transactions()->orderBy('created_at')->orderBy('id')->get();

        $runningBalance = 0;

        foreach ($transactions as $transaction) {
            // Hitung saldo berjalan
            $runningBalance += $transaction->debit;
            $runningBalance -= $transaction->kredit;

            // Update saldo_akhir pada setiap transaksi
            $transaction->saldo_akhir = $runningBalance;
            $transaction->save();
        }

        // Update balance utama di tabel saldo
        $saldo->balance = $runningBalance;
        $saldo->save();
    }
}
