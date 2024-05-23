<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('poll_responses', function (Blueprint $table) {
            $table->id();
            $table->string('response');
            $table->integer('count');
            $table->json('users')->nullable();

            $table->foreignId('poll_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('poll_responses');
    }
};
