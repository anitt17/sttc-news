<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $beritas = [
            [
                'judul'       => 'Seminar Nasional Teknologi 2026',
                'isi'         => 'STTC mengadakan seminar nasional teknologi yang dihadiri oleh ratusan mahasiswa dan dosen.',
                'tanggal'     => '2026-04-01',
                'id_kategori' => 2,
                'id_admin'    => 1,
            ],
            [
                'judul'       => 'Pengumuman Jadwal UTS Semester Genap',
                'isi'         => 'Jadwal UTS semester genap telah ditetapkan. Mahasiswa diharap mempersiapkan diri dengan baik.',
                'tanggal'     => '2026-04-05',
                'id_kategori' => 1,
                'id_admin'    => 1,
            ],
            [
                'judul'       => 'Mahasiswa STTC Raih Juara Lomba Teknologi',
                'isi'         => 'Tim mahasiswa STTC berhasil meraih juara pertama dalam lomba teknologi tingkat nasional.',
                'tanggal'     => '2026-04-10',
                'id_kategori' => 4,
                'id_admin'    => 1,
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }
    }
}