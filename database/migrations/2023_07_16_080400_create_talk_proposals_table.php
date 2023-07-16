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
        Schema::create('talk_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speaker_id')
                  ->constrained('speakers')
                  ->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('abstract');
            $table->string('preferred_time_slot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_proposals');
    }
};
