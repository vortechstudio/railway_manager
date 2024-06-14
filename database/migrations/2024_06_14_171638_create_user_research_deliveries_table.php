<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_research_deliveries', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('designation');
            $table->foreignId('research_user_id');
            $table->foreignId('user_railway_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_research_deliveries');
    }
};
