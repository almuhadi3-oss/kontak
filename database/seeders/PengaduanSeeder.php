<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaduan::create([
            'kode_laporan' => 'PGD-0001',
            'id_layanan' => 1,
            'nama' => 'John Doe',
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Contoh No. 1',
            'laporan' => 'Laporan contoh untuk layanan 1',
            'status' => 'baru',
            'foto' => null,
            'surat_pengantar' => null,
            'kk' => null,
            'ktp' => null,
            'bpjs' => null,
        ]);

        Pengaduan::create([
            'kode_laporan' => 'PGD-0002',
            'id_layanan' => 2,
            'nama' => 'Jane Smith',
            'nik' => '6543210987654321',
            'alamat' => 'Jl. Contoh No. 2',
            'laporan' => 'Laporan contoh untuk layanan 2',
            'status' => 'diproses',
            'foto' => null,
            'surat_pengantar' => null,
            'kk' => null,
            'ktp' => null,
            'bpjs' => null,
        ]);
    }
}
