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
        Schema::create('memos', function (Blueprint $table) {

             $table->id();

            $table->foreignId('sender_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('receiver_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('target_role')
                ->nullable();

            $table->string('link')
                ->nullable();

            $table->boolean('send_to_all')
                ->default(false);

            $table->string('title');

            $table->text('message')
                ->nullable();

            $table->string('file')
                ->nullable();

            $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
