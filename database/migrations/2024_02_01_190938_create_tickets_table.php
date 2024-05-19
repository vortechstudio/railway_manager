<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('tickets', function (Blueprint $table) {
                $table->id();
                $table->string('subject');
                $table->string('status')->default('open');
                $table->string('priority')->default('medium');
                $table->softDeletes();
                $table->timestamps();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('service_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('ticket_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('tickets');
    }
};
