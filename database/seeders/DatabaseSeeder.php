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
        | 1. DIVISI
        |--------------------------------------------------------------------------
        */

        $operasional = Division::firstOrCreate([
            'name' => 'Operasional',
        ]);

        $keuangan = Division::firstOrCreate([
            'name' => 'Keuangan',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. KATEGORI OPERASIONAL
        |--------------------------------------------------------------------------
        */

        $operasionalCategories = [
            'Perilaku Pengemudi',
            'Fasilitas Halte Rusak',
            'Kondisi Armada (AC Mati, dll)',
        ];

        foreach ($operasionalCategories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['division_id' => $operasional->id]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 3. KATEGORI KEUANGAN
        |--------------------------------------------------------------------------
        */

        $keuanganCategories = [
            'Masalah Tarif / Tiket',
            'Masalah Pembayaran',
            'Masalah Transaksi Cashless',
            'Refund / Pengembalian Dana',
        ];

        foreach ($keuanganCategories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['division_id' => $keuangan->id]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 4. AKUN PENGGUNA UMUM
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Penumpang',
                'password' => Hash::make('password123'),
                'role' => 'pengguna',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 5. AKUN CC ROOM
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'cc@trans.com'],
            [
                'name' => 'Admin CC Room',
                'password' => Hash::make('password123'),
                'role' => 'cc_room',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 6. AKUN MANAGER KEUANGAN
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'manager.keuangan@trans.com'],
            [
                'name' => 'Manager Keuangan',
                'password' => Hash::make('password123'),
                'role' => 'manager_keuangan',
                'division_id' => $keuangan->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 7. AKUN MANAGER OPERASIONAL
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'manager.operasional@trans.com'],
            [
                'name' => 'Manager Operasional',
                'password' => Hash::make('password123'),
                'role' => 'manager_operasional',
                'division_id' => $operasional->id,
            ]
        );
    }
}
