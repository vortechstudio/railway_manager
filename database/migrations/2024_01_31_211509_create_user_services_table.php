<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('user_services', function (Blueprint $table) {
                $table->id();
                $table->boolean('status');
                $table->boolean('premium');

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('service_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->timestamps();
                $table->softDeletes();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('user_services');
    }
};
