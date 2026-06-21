<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Contoh: TKT-20260610-0001
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null'); // Diisi setelah CC Room disposisi
            
            // Detail Laporan dari Pengguna
            $table->string('title');
            $table->text('description');
            $table->dateTime('incident_time');
            $table->string('bus_number')->nullable(); // Nomor lambung bus
            $table->string('evidence_path')->nullable(); // Path foto bukti dari pelapor
            
            // Status Alur Kerja
            $table->enum('status', ['menunggu', 'diproses', 'menunggu_validasi_cc', 'selesai', 'ditolak'])->default('menunggu');
            
            // Kolom Penyelesaian dari Kadiv
            $table->text('resolution_notes')->nullable();
            $table->string('resolution_proof_path')->nullable(); // Path foto bukti perbaikan
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};