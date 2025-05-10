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
          Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->date('tanggal_masuk');
            $table->string('nama_kapal');
            $table->string('lokasi');
            $table->string('jenis_pekerjaan');
            $table->date('tanggal_inspeksi')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->foreignId('status_id')->constrained('project_statuses')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
