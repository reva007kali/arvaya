<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Pembuat Undangan)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identitas Undangan
            $table->string('slug')->unique(); // domain.com/reza-adinda
            $table->string('title'); // Judul internal dashboard

            // Template & Tema
            $table->string('theme_template')->default('regular'); // Nama file blade (misal: rustic, floral)
            $table->json('theme_config')->nullable(); // { "primary_color": "#AABBCC", "font": "Poppins", "music_url": "..." }

            // Data Utama (JSON agar fleksibel)
            // Struktur: { "groom": { "name": "...", "father": "...", ... }, "bride": { ... } }
            $table->json('couple_data');

            // Data Acara (Bisa lebih dari 1 sesi)
            // Struktur: [ { "name": "Akad", "date": "...", "location": "..." }, { "name": "Resepsi", ... } ]
            $table->json('event_data');

            // Fitur Tambahan
            $table->json('gallery_data')->nullable(); // Array paths foto prewedding
            $table->json('gifts_data')->nullable(); // Data Bank/E-Wallet/QRIS untuk angpao

            // Fitur AI Summary (Menyimpan hasil generate AI dari ucapan tamu)
            $table->text('ai_wishes_summary')->nullable();

            // Status & Meta
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('visit_count')->default(0); // Hitung pengunjung

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
