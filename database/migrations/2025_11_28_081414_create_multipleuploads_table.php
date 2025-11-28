<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('multipleuploads', function (Blueprint $table) {
            $table->id();
            $table->string('ref_table', 100); // nama tabel referensi (pelanggan)
            $table->integer('ref_id'); // ID data pada tabel tersebut (pelanggan_id)
            $table->string('file_path'); // path file yang diupload
            $table->string('file_name'); // nama asli file
            $table->string('file_type')->nullable(); // tipe file (image, document, etc)
            $table->integer('file_size')->nullable(); // ukuran file dalam bytes
            $table->timestamps();

            // Index untuk performa query
            $table->index(['ref_table', 'ref_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multipleuploads');
    }
};
