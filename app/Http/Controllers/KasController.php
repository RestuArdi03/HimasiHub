<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Saldo $saldo)
    {
        if ($saldo->nama !== 'Kas') {
            abort(404);
        }
        $this->authorize('view', $saldo);

        // Ambil semua anggota (asumsi semua user adalah anggota)
        $members = User::orderBy('nama')->get();

        // Ambil semua transaksi kas (debit) dan kelompokkan berdasarkan user_id
        // Format keterangan diasumsikan: "Iuran Kas ke-X"
        $transactions = $saldo->transactions()
            ->where('debit', '>', 0)
            ->where('keterangan', 'like', 'Iuran Kas ke-%')
            ->get()
            ->groupBy('users_id');

        // Ambil pengaturan dari model Saldo, gunakan default jika null
        $maxPayments = $saldo->jumlah_iuran ?? 12;
        $biayaIuran = $saldo->iuran_nominal ?? 5000;

        return view('backend.kas.index', compact('saldo', 'members', 'transactions', 'maxPayments', 'biayaIuran'));
    }

    /**
     * Mark a due as paid.
     */
    public function pay(Request $request, Saldo $saldo, User $member)
    {
        $this->authorize('create', Transaksi::class);

        $biayaIuran = $saldo->iuran_nominal ?? 5000;
        $iuranKe = $request->input('iuran_ke');

        // Gunakan transaksi database untuk memastikan konsistensi
        DB::transaction(function () use ($saldo, $member, $biayaIuran, $iuranKe) {
            // Buat transaksi baru
            Transaksi::create([
                'saldo_id' => $saldo->id,
                'users_id' => $member->id, // ID anggota yang membayar
                'keterangan' => "Iuran Kas ke-{$iuranKe} - {$member->nama}",
                'debit' => $biayaIuran,
                'kredit' => 0,
            ]);

            // Hitung ulang saldo
            $this->recalculateSaldo($saldo);
        });

        return redirect()->route('backend.kas.index', $saldo->id)->with('success', "Pembayaran kas untuk {$member->nama} berhasil dicatat.");
    }

    /**
     * Un-pay a due (delete the transaction).
     */
    public function unpay(Transaksi $transaksi)
    {
        $this->authorize('delete', $transaksi);
        $saldo = $transaksi->saldo;

        DB::transaction(function () use ($transaksi, $saldo) {
            $transaksi->forceDelete(); // Hapus permanen karena ini pembatalan, bukan soft delete
            $this->recalculateSaldo($saldo);
        });

        return redirect()->route('backend.kas.index', $saldo->id)->with('success', 'Pembayaran kas berhasil dibatalkan.');
    }

    /**
     * Update kas settings.
     */
    public function updateSettings(Request $request, Saldo $saldo)
    {
        $this->authorize('update', $saldo);

        $validated = $request->validate([
            'iuran_nominal' => 'required|numeric|min:0',
            'jumlah_iuran' => 'required|integer|min:1',
        ]);

        $saldo->update([
            'iuran_nominal' => $validated['iuran_nominal'],
            'jumlah_iuran' => $validated['jumlah_iuran'],
        ]);

        return redirect()->route('backend.kas.index', $saldo->id)->with('success', 'Pengaturan iuran kas berhasil diperbarui.');
    }


    private function recalculateSaldo(Saldo $saldo)
    {
        $saldo = Saldo::lockForUpdate()->find($saldo->id);
        $newBalance = $saldo->transactions()->sum('debit') - $saldo->transactions()->sum('kredit');
        $saldo->balance = $newBalance;
        $saldo->save();
    }
}
