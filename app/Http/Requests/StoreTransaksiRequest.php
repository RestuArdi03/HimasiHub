<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Saldo;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi akan ditangani oleh policy di controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'saldo_id' => 'required|exists:saldo,id',
            'keterangan' => 'required|string|max:255',
            'jenis_transaksi' => 'required|in:debit,kredit',
            'jumlah' => 'required|numeric|min:0.01',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB,
            'member_id' => 'nullable|exists:users,id',
        ];
    }
}
