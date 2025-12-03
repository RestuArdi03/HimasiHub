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

        // Ambil semua anggota yang memiliki anggota_id
        $members = User::whereNotNull('anggota_id')->orderBy('nama')->get();

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

        // Cek apakah user memiliki hak akses untuk mengelola kas (create/delete transaksi)
        $canManageKas = auth()->user()->can('create', Transaksi::class);

        return view('backend.kas.index', compact('saldo', 'members', 'transactions', 'maxPayments', 'biayaIuran', 'canManageKas'));
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

    /**
     * Reset the 'Kas' saldo by moving all its transactions to a new archive saldo.
     */
    public function resetKas(Saldo $saldo)
    {
        // Pastikan ini adalah saldo 'Kas'
        if ($saldo->nama !== 'Kas') {
            abort(404, 'Hanya saldo "Kas" yang dapat direset.');
        }

        // Otorisasi aksi (misalnya, izin 'update' pada model Saldo)
        $this->authorize('update', $saldo);

        $archiveSaldoName = 'Iuran Kas ' . date('M Y');

        DB::transaction(function () use ($saldo, $archiveSaldoName) {
            // 1. Buat saldo arsip baru untuk transaksi tahun ini
            $archiveSaldo = Saldo::create([
                'nama' => $archiveSaldoName, // Gunakan variabel dari scope luar
                'balance' => 0, // Akan diperbarui setelah memindahkan transaksi
                'iuran_nominal' => $saldo->iuran_nominal, // Salin pengaturan
                'jumlah_iuran' => $saldo->jumlah_iuran,   // Salin pengaturan
            ]);

            // 2. Pindahkan semua transaksi dari saldo 'Kas' ke saldo arsip yang baru
            // Ini akan memindahkan semua transaksi yang terkait dengan saldo 'Kas' saat ini.
            $saldo->transactions()->update(['saldo_id' => $archiveSaldo->id]);

            // 3. Reset saldo 'Kas' yang asli
            $saldo->balance = 0;
            // Pengaturan iuran_nominal dan jumlah_iuran tetap dipertahankan untuk periode berikutnya
            $saldo->save();

            // 4. Hitung ulang saldo untuk saldo arsip
            $this->recalculateSaldo($archiveSaldo); // Ini akan menghitung berdasarkan transaksi yang dipindahkan.
            // Saldo 'Kas' yang asli sudah diatur ke 0 dan disimpan, tidak perlu dihitung ulang.
        });

        return redirect()->route('backend.kas.index', $saldo->id)->with('success', 'Saldo "Kas" berhasil direset. Transaksi lama dipindahkan ke "' . $archiveSaldoName . '".');
    }

    /**
     * Helper method to recalculate and update a saldo's balance.
     * @param Saldo $saldo
     */
    protected function recalculateSaldo(Saldo $saldo)
    {
        $saldo->refresh(); // Refresh model to get latest transactions if any were just moved/added
        $newBalance = $saldo->transactions()->sum('debit') - $saldo->transactions()->sum('kredit');
        $saldo->update(['balance' => $newBalance]);
    }
}
