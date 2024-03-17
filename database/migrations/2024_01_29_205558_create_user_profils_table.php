<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profils', function (Blueprint $table) {
            $table->id();
            $table->string('signature')->nullable();
            $table->integer('nb_views')->default(0);
            $table->boolean('banned')->default(false);
            $table->timestamp('banned_at')->nullable();
            $table->timestamp('banned_for')->nullable();
            $table->integer('avertissement')->default(0);
            $table->boolean('notification')->default(true);
            $table->boolean('newsletter')->default(true);
            $table->boolean('wiki_contrib')->default(false);

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profils');
    }
};
