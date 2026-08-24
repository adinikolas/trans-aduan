<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Pastikan division "Operasional" tersedia
        |--------------------------------------------------------------------------
        */

        $operasional = DB::table('divisions')
            ->where('name', 'Operasional')
            ->first();

        if (!$operasional) {
            $operasionalId = DB::table('divisions')->insertGetId([
                'name' => 'Operasional',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $operasionalId = $operasional->id;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Buat Division Keuangan
        |--------------------------------------------------------------------------
        */

        $keuangan = DB::table('divisions')
            ->where('name', 'Keuangan')
            ->first();

        if (!$keuangan) {
            $keuanganId = DB::table('divisions')->insertGetId([
                'name' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $keuanganId = $keuangan->id;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Pindahkan kategori operasional lama
        |--------------------------------------------------------------------------
        */

        DB::table('categories')
            ->whereIn('name', [
                'Perilaku Pengemudi',
                'Fasilitas Halte Rusak',
                'Kondisi Armada (AC Mati, dll)',
            ])
            ->update([
                'division_id' => $operasionalId,
                'updated_at' => now(),
            ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Tambahkan kategori Keuangan
        |--------------------------------------------------------------------------
        */

        $financeCategories = [
            'Masalah Tarif / Tiket',
            'Masalah Pembayaran',
            'Masalah Transaksi Cashless',
            'Refund / Pengembalian Dana',
        ];

        foreach ($financeCategories as $categoryName) {
            $exists = DB::table('categories')
                ->where('name', $categoryName)
                ->exists();

            if (!$exists) {
                DB::table('categories')->insert([
                    'name' => $categoryName,
                    'division_id' => $keuanganId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Pindahkan data complaint lama ke Operasional
        |--------------------------------------------------------------------------
        |
        | Aduan lama yang kategorinya merupakan kategori operasional
        | akan diberi division_id Operasional.
        |
        */

        DB::statement("
            UPDATE complaints c
            INNER JOIN categories cat ON c.category_id = cat.id
            SET c.division_id = cat.division_id
            WHERE cat.division_id IS NOT NULL
        ");
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus kategori Keuangan yang dibuat migration ini
        |--------------------------------------------------------------------------
        */

        DB::table('categories')
            ->whereIn('name', [
                'Masalah Tarif / Tiket',
                'Masalah Pembayaran',
                'Masalah Transaksi Cashless',
                'Refund / Pengembalian Dana',
            ])
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Kembalikan nama Operasional menjadi nama lama
        |--------------------------------------------------------------------------
        */

        DB::table('divisions')
            ->where('name', 'Operasional')
            ->update([
                'name' => 'Kepala Divisi',
                'updated_at' => now(),
            ]);

        /*
        |--------------------------------------------------------------------------
        | Hapus division Keuangan
        |--------------------------------------------------------------------------
        */

        DB::table('divisions')
            ->where('name', 'Keuangan')
            ->delete();
    }
};
