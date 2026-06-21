<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Division;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat HANYA 1 Data Divisi (Sesuai Rancangan Anda)
        $divUtama = Division::create(['name' => 'Kepala Divisi']);

        // 2. Semua Kategori dimasukkan ke 1 Divisi tersebut
        Category::create(['name' => 'Perilaku Pengemudi', 'division_id' => $divUtama->id]);
        Category::create(['name' => 'Fasilitas Halte Rusak', 'division_id' => $divUtama->id]);
        Category::create(['name' => 'Kondisi Armada (AC Mati, dll)', 'division_id' => $divUtama->id]);

        // 3. Membuat Akun Pengguna Jasa (Masyarakat)
        User::create([
            'name' => 'Budi Penumpang',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pengguna',
        ]);

        // 4. Membuat Akun CC Room
        User::create([
            'name' => 'Admin CC Room',
            'email' => 'cc@trans.com',
            'password' => Hash::make('password123'),
            'role' => 'cc_room',
        ]);

        // 5. Membuat Akun Kepala Divisi
        User::create([
            'name' => 'Kepala Divisi',
            'email' => 'kadiv@trans.com',
            'password' => Hash::make('password123'),
            'role' => 'kadiv',
            'division_id' => $divUtama->id, 
        ]);
    }
}