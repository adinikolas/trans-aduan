<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Tambahkan role manager ke ENUM terlebih dahulu
        |--------------------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'pengguna',
                'cc_room',
                'kadiv',
                'manager_keuangan',
                'manager_operasional'
            )
            NOT NULL DEFAULT 'pengguna'
        ");

        /*
        |--------------------------------------------------------------------------
        | 2. Migrasikan akun Kadiv lama
        |--------------------------------------------------------------------------
        |
        | Akun Kadiv lama dipindahkan menjadi Manager Operasional
        | agar akun dan data yang sudah ada tetap aman.
        |
        */
        DB::table('users')
            ->where('role', 'kadiv')
            ->update([
                'role' => 'manager_operasional',
            ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Hapus role kadiv dari ENUM
        |--------------------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'pengguna',
                'cc_room',
                'manager_keuangan',
                'manager_operasional'
            )
            NOT NULL DEFAULT 'pengguna'
        ");
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Tambahkan kembali role kadiv
        |--------------------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'pengguna',
                'cc_room',
                'kadiv',
                'manager_keuangan',
                'manager_operasional'
            )
            NOT NULL DEFAULT 'pengguna'
        ");

        /*
        |--------------------------------------------------------------------------
        | 2. Kembalikan Manager Operasional menjadi Kadiv
        |--------------------------------------------------------------------------
        */
        DB::table('users')
            ->where('role', 'manager_operasional')
            ->update([
                'role' => 'kadiv',
            ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Kembalikan ENUM lama
        |--------------------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE users
            MODIFY COLUMN role ENUM(
                'pengguna',
                'cc_room',
                'kadiv'
            )
            NOT NULL DEFAULT 'pengguna'
        ");
    }
};
