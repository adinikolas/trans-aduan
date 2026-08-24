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
        /*
        |--------------------------------------------------------------------------
        | 1. Membuat Divisi
        |--------------------------------------------------------------------------
        |
        | Untuk sementara struktur divisi tetap menggunakan satu divisi
        | yang sudah ada pada rancangan aplikasi.
        |
        | Nama "Kepala Divisi" diubah menjadi "Operasional" karena
        | role Kadiv sudah tidak digunakan.
        |
        */
        $divUtama = Division::create([
            'name' => 'Operasional'
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Kategori Aduan
        |--------------------------------------------------------------------------
        */
        Category::create([
            'name' => 'Perilaku Pengemudi',
            'division_id' => $divUtama->id
        ]);

        Category::create([
            'name' => 'Fasilitas Halte Rusak',
            'division_id' => $divUtama->id
        ]);

        Category::create([
            'name' => 'Kondisi Armada (AC Mati, dll)',
            'division_id' => $divUtama->id
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Akun Pengguna Umum
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Budi Penumpang',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pengguna',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Akun CC Room
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Admin CC Room',
            'email' => 'cc@trans.com',
            'password' => Hash::make('password123'),
            'role' => 'cc_room',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. Akun Manager Keuangan
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Manager Keuangan',
            'email' => 'manager.keuangan@trans.com',
            'password' => Hash::make('password123'),
            'role' => 'manager_keuangan',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 6. Akun Manager Operasional
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Manager Operasional',
            'email' => 'manager.operasional@trans.com',
            'password' => Hash::make('password123'),
            'role' => 'manager_operasional',
        ]);
    }
}
