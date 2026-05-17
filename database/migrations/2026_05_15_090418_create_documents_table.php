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
       Schema::create('documents', function (Blueprint $table) {
        $table->id();

        $table->string('nomor_dokumen');
        $table->string('judul');
        $table->string('file');

        $table->enum('status', [
            'pending_manager',
            'approved_manager',
            'rejected_manager',
            'pending_director',
            'approved_final',
            'rejected_final'
        ])->default('pending_manager');

        $table->foreignId('uploaded_by')
            ->constrained('users')
            ->onDelete('cascade');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
