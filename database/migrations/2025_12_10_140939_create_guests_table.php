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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');

            $table->string('name'); // Nama Tamu
            $table->string('slug'); // Slug unik per undangan (misal: bapak-budi)
            $table->string('category')->nullable(); // Grup: Keluarga, Teman Kantor, Sekolah
            $table->string('phone')->nullable(); // Untuk kirim WA

            // RSVP
            // 0: Belum konfirmasi, 1: Hadir, 2: Tidak Hadir, 3: Ragu-ragu
            $table->tinyInteger('rsvp_status')->default(0);
            $table->integer('pax')->default(1); // Jumlah orang yang akan dibawa

            $table->text('message_from_guest')->nullable(); // Pesan khusus saat RSVP

            $table->timestamps();

            // Constraint: Slug tamu harus unik DALAM SATU UNDANGAN (bukan global)
            // Jadi user A bisa punya tamu 'budi', user B juga bisa punya tamu 'budi'
            $table->unique(['invitation_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
