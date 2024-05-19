<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('user_services', function (Blueprint $table) {
                $table->id();
                $table->boolean('status')->default(true);
                $table->boolean('premium')->default(false);

                $table->foreignId('user_id');

                $table->foreignId('service_id');

                $table->timestamps();
                $table->softDeletes();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('user_services');
    }
};
