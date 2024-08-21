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
        Schema::create('data_cuti', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk');
            $table->date('tanggal_cuti');
            $table->integer('lama_cuti');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('nomor_induk')->references('nomor_induk')->on('data_karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_cuti');
    }
};
