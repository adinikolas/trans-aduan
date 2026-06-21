<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->onDelete('cascade');
            $table->string('status'); // Status saat perubahan terjadi
            $table->text('note')->nullable(); // Catatan alasan ganti status (misal: "Foto kurang jelas, tolong direvisi")
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Aktor yang mengubah status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_histories');
    }
};