<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    // Menampilkan semua laporan pengaduan
    public function index()
    {
        $query = Pengaduan::orderBy('created_at', 'desc');

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kode_laporan', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('laporan', 'like', '%' . $search . '%');
            });
        }

        $data = $query->get();
        return view('admin.pengaduan', compact('data'));
    }

    // Mengubah status laporan
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        $message = 'Status laporan berhasil diperbarui!';
        if ($request->status == 'diproses') {
            $message = 'Laporan telah dipindahkan ke status diproses.';
        } elseif ($request->status == 'selesai') {
            $message = 'Laporan telah diselesaikan.';
        }

        return redirect()->back()->with('success', $message);
    }

    // Menghapus laporan (tolak)
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus file yang diupload jika ada
        $files = ['foto', 'surat_pengantar', 'kk', 'ktp', 'bpjs'];
        foreach ($files as $file) {
            if ($pengaduan->$file && \Storage::disk('public')->exists($pengaduan->$file)) {
                \Storage::disk('public')->delete($pengaduan->$file);
            }
        }

        $pengaduan->delete();

        return redirect()->back()->with('success', 'Laporan telah ditolak dan dihapus.');
    }

    // Menghapus laporan secara permanen (general delete)
    public function deleteGeneral($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus file yang diupload jika ada
        $files = ['foto', 'surat_pengantar', 'kk', 'ktp', 'bpjs'];
        foreach ($files as $file) {
            if ($pengaduan->$file && \Storage::disk('public')->exists($pengaduan->$file)) {
                \Storage::disk('public')->delete($pengaduan->$file);
            }
        }

        $pengaduan->delete();

        return redirect()->back()->with('success', 'Laporan telah dihapus secara permanen.');
    }
    //store
   public function store(Request $request)
{
    $validated = $request->validate([
        'id_layanan' => 'nullable|integer',
        'nama' => 'required|string|max:100',
        'nik' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
        'no_kk' => 'nullable|string|max:20',
        'no_bpjs' => 'nullable|string|max:20',
        'no_hp' => 'nullable|string|max:20',
        'laporan' => 'required|string',
        'foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'surat_pengantar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'bpjs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $kode = 'PGD-' . str_pad(\App\Models\Pengaduan::count() + 1, 4, '0', STR_PAD_LEFT);

    $paths = [];
    foreach (['foto', 'surat_pengantar', 'kk', 'ktp', 'bpjs'] as $field) {
        if ($request->hasFile($field)) {
            $paths[$field] = $request->file($field)->store('berkas', 'public');
        } else {
            $paths[$field] = null;
        }
    }

    \App\Models\Pengaduan::create([
        'kode_laporan' => $kode,
        'id_layanan' => $request->id_layanan,
        'nama' => $request->nama,
        'nik' => $request->nik,
        'alamat' => $request->alamat,
        'laporan' => $request->laporan,
        'no_kk' => $request->no_kk,
        'no_bpjs' => $request->no_bpjs,
        'no_hp' => $request->no_hp,
        'status' => 'baru',
        'foto' => $paths['foto'],
        'surat_pengantar' => $paths['surat_pengantar'],
        'kk' => $paths['kk'],
        'ktp' => $paths['ktp'],
        'bpjs' => $paths['bpjs'],
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Laporan dan berkas berhasil dikirim!',
        'kode_laporan' => $kode,
    ]);
}

    // Cek status laporan berdasarkan kode
    public function cekStatus($kode)
    {
        $pengaduan = Pengaduan::where('kode_laporan', $kode)->first();

        if ($pengaduan) {
            $message = '';
            if ($pengaduan->status == 'diproses') {
                $layananMessages = [
                    1 => 'sedang di proses, tunggu 1 hari kerja.',
                    2 => 'sedang di proses, tunggu 2 hari kerja.',
                    3 => 'jangka waktu selama 6 bulan.',
                    4 => 'jangka waktu 2 minggu/lebih.',
                    5 => 'jangka waktu 3 hari.',
                    6 => 'jangka waktu 1 hari kerja setelah persyaratan dilengkapi.',
                    7 => 'jangka waktu 4 hari.',
                    8 => 'jangka waktu 1 hari kerja setelah persyaratan dilengkapi.',
                    9 => 'jangka waktu 1-4 hari kerja. Silahkan cek kembali nanti.',
                    10 => '1 bulan kerja.',
                    11 => '1 hari – 4 hari kerja silahkan cek disini.',
                    12 => '3 hari kerja.',
                    13 => '3 hari kerja.',
                ];
                $message = 'Layanan ' . ($layananMessages[$pengaduan->id_layanan] ?? 'sedang diproses.');
            } elseif ($pengaduan->status == 'selesai') {
                $layananMessages = [
                    1 => 'data anda sudah masuk di data PMKS penyandang disabilitas.',
                    2 => 'data anda sudah masuk di data PMKS.',
                    3 => 'info lebih lanjut ke ruang rehabilitasi sosial, dinas sosial Indragiri Hilir.',
                    4 => 'bantuan anda sudah cair.',
                    5 => 'anda sudah terdaftar sebagai PMKS.',
                    6 => 'bantuan akan di kirim.',
                    7 => 'data anda terdata sebagai penerima PKH.',
                    8 => 'selamat anda akan di pulangkan ke kampung halaman.',
                    9 => 'kartu Indonesia sehat anda sudah siap!',
                    10 => 'data anda sudah masuk kedalam Data Terpadu Kesejahteraan Sosial (DTKS).',
                    11 => 'surat rekomendasi anda sudah keluar silahkan ambil di bagian pelayanan Dinas Sosial Indragiri Hilir.',
                    12 => 'surat izin anda sudah keluar.',
                    13 => 'surat izin anda sudah keluar.',
                ];
                $message = 'Layanan ' . ($layananMessages[$pengaduan->id_layanan] ?? 'sudah selesai.');
            }

            return response()->json([
                'status' => 'success',
                'data' => $pengaduan,
                'message' => $message
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }
    }

}
