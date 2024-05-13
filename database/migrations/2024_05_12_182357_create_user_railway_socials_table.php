<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_railway_socials', function (Blueprint $table) {
            $table->id();
            $table->boolean('accept_friends')->default(false);
            $table->boolean('display_registry')->default(false);
            $table->boolean('display_online_status')->default(false);
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_railway_socials');
    }
};
