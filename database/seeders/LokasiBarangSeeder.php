<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LokasiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Barang::truncate();
        Lokasi::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lokasi data
        $lokasiData = [
            ['nama_lokasi' => 'Ruang Kelas 7A', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 8A', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 8B', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 9A', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 9B', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Guru', 'aktif' => true],
            ['nama_lokasi' => 'Kantin', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 2', 'aktif' => true],
            ['nama_lokasi' => 'Lapangan Olahraga', 'aktif' => true],
            ['nama_lokasi' => 'Aula', 'aktif' => true],
        ];

        foreach ($lokasiData as $lokasi) {
            Lokasi::create($lokasi);
        }

        // Barang data berdasarkan lokasi
        $barangData = [
            // Ruang Kelas 7A
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Meja Siswa', 'deskripsi' => 'Meja untuk siswa', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Kursi Siswa', 'deskripsi' => 'Kursi untuk siswa', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Papan Tulis', 'deskripsi' => 'Whiteboard', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'AC', 'deskripsi' => 'Air Conditioner', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Kipas Angin', 'deskripsi' => 'Kipas angin langit-langit', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Lampu', 'deskripsi' => 'Lampu LED', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7A', 'nama_barang' => 'Proyektor', 'deskripsi' => 'LCD Proyektor', 'aktif' => true],

            // Ruang Kelas 7B
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'Meja Siswa', 'deskripsi' => 'Meja untuk siswa', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'Kursi Siswa', 'deskripsi' => 'Kursi untuk siswa', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'Papan Tulis', 'deskripsi' => 'Whiteboard', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'AC', 'deskripsi' => 'Air Conditioner', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'Kipas Angin', 'deskripsi' => 'Kipas angin langit-langit', 'aktif' => true],
            ['nama_lokasi' => 'Ruang Kelas 7B', 'nama_barang' => 'Lampu', 'deskripsi' => 'Lampu LED', 'aktif' => true],

            // Lab Komputer
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Komputer PC', 'deskripsi' => 'PC Desktop', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Monitor', 'deskripsi' => 'Monitor LCD', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Keyboard', 'deskripsi' => 'Keyboard USB', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Mouse', 'deskripsi' => 'Mouse USB', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Meja Komputer', 'deskripsi' => 'Meja untuk PC', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Kursi Putar', 'deskripsi' => 'Kursi putar untuk lab', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'AC', 'deskripsi' => 'Air Conditioner', 'aktif' => true],
            ['nama_lokasi' => 'Lab Komputer', 'nama_barang' => 'Proyektor', 'deskripsi' => 'LCD Proyektor', 'aktif' => true],

            // Lab IPA
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Mikroskop', 'deskripsi' => 'Mikroskop untuk praktikum', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Bunsen Burner', 'deskripsi' => 'Pembakar bunsen', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Tabung Reaksi', 'deskripsi' => 'Set tabung reaksi', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Meja Praktikum', 'deskripsi' => 'Meja praktikum IPA', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Kursi Lab', 'deskripsi' => 'Kursi tinggi untuk lab', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Lemari Alat', 'deskripsi' => 'Lemari penyimpanan alat', 'aktif' => true],
            ['nama_lokasi' => 'Lab IPA', 'nama_barang' => 'Wastafel', 'deskripsi' => 'Wastafel untuk cuci tangan', 'aktif' => true],

            // Perpustakaan
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'Rak Buku', 'deskripsi' => 'Rak untuk menyimpan buku', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'Meja Baca', 'deskripsi' => 'Meja untuk membaca', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'Kursi Baca', 'deskripsi' => 'Kursi untuk membaca', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'AC', 'deskripsi' => 'Air Conditioner', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'Lampu Baca', 'deskripsi' => 'Lampu untuk area baca', 'aktif' => true],
            ['nama_lokasi' => 'Perpustakaan', 'nama_barang' => 'Komputer Katalog', 'deskripsi' => 'PC untuk katalog buku', 'aktif' => true],

            // Toilet Lt. 1
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Kloset', 'deskripsi' => 'Toilet duduk', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Wastafel', 'deskripsi' => 'Wastafel cuci tangan', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Kran Air', 'deskripsi' => 'Kran air', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Cermin', 'deskripsi' => 'Cermin dinding', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Exhaust Fan', 'deskripsi' => 'Kipas exhaust', 'aktif' => true],
            ['nama_lokasi' => 'Toilet Lt. 1', 'nama_barang' => 'Lampu', 'deskripsi' => 'Lampu toilet', 'aktif' => true],

            // Kantin
            ['nama_lokasi' => 'Kantin', 'nama_barang' => 'Meja Makan', 'deskripsi' => 'Meja untuk makan', 'aktif' => true],
            ['nama_lokasi' => 'Kantin', 'nama_barang' => 'Kursi Makan', 'deskripsi' => 'Kursi untuk makan', 'aktif' => true],
            ['nama_lokasi' => 'Kantin', 'nama_barang' => 'Wastafel', 'deskripsi' => 'Tempat cuci tangan', 'aktif' => true],
            ['nama_lokasi' => 'Kantin', 'nama_barang' => 'Kipas Angin', 'deskripsi' => 'Kipas angin dinding', 'aktif' => true],

            // Lapangan Olahraga
            ['nama_lokasi' => 'Lapangan Olahraga', 'nama_barang' => 'Ring Basket', 'deskripsi' => 'Ring basket outdoor', 'aktif' => true],
            ['nama_lokasi' => 'Lapangan Olahraga', 'nama_barang' => 'Net Voli', 'deskripsi' => 'Net untuk voli', 'aktif' => true],
            ['nama_lokasi' => 'Lapangan Olahraga', 'nama_barang' => 'Gawang Futsal', 'deskripsi' => 'Gawang untuk futsal', 'aktif' => true],
            ['nama_lokasi' => 'Lapangan Olahraga', 'nama_barang' => 'Lampu Taman', 'deskripsi' => 'Lampu penerangan lapangan', 'aktif' => true],
        ];

        foreach ($barangData as $barang) {
            Barang::create($barang);
        }

        $this->command->info('✅ Lokasi dan Barang berhasil di-seed!');
    }
}
