<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Akademik'],
            ['nama_kategori' => 'Kegiatan'],
            ['nama_kategori' => 'Pengumuman'],
            ['nama_kategori' => 'Prestasi'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}