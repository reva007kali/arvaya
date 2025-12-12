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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Tampilan (misal: Arvaya Rustic)
            $table->string('slug')->unique(); // ID unik (misal: rustic, elegant) -> harus match nama file blade

            // Asset Preview
            $table->string('thumbnail')->nullable(); // Foto Cover
            $table->string('preview_video')->nullable(); // Video Preview
            $table->text('description')->nullable();

            // LOGIC BARU: TIER & PRICE
            // Tier menentukan fitur apa saja yang didapat (Basic, Premium, Exclusive)
            $table->enum('tier', ['basic', 'premium', 'exclusive'])->default('basic');

            // Price menentukan harga jual template ini
            $table->decimal('price', 12, 2)->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
