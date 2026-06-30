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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // whom taken the action
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // using morphin create 2 tbale one contaiting id and second column represents the type.
            $table->morphs('loggable');
            
            // Action  type: created, updated, deleted, status_changed
            $table->string('action');
            $table->text('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
