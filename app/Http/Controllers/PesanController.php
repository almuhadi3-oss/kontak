<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
class PesanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'subjek' => 'nullable|string|max:150',
            'pesan' => 'required|string',
        ]);

        // Simpan ke database
        Pesan::create($validated);

        // Kirim respon ke frontend
        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil disimpan. Terima kasih atas laporan Anda!'
        ]);
    }
}
