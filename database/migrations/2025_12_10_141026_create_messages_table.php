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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');

            // Jika yang komen adalah tamu terdaftar (via link khusus)
            $table->foreignId('guest_id')->nullable()->constrained()->onDelete('cascade');

            // Untuk fitur Reply (Balasan Mempelai)
            $table->foreignId('parent_id')->nullable()->references('id')->on('messages')->onDelete('cascade');

            // Nama pengirim (diambil dari guest_id jika ada, atau input manual jika tamu umum)
            $table->string('sender_name');

            $table->text('content'); // Isi ucapan

            // Penanda apakah ini balasan resmi dari pemilik undangan (mempelai)
            $table->boolean('is_reply_from_owner')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
