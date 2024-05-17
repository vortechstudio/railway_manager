<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('user_socials', function (Blueprint $table) {
                $table->id();
                $table->string('provider');
                $table->string('provider_id');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->timestamps();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('user_socials');
    }
};
