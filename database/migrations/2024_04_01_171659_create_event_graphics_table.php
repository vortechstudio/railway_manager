<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('event_graphics', function (Blueprint $table) {
                $table->id();
                $table->string('type_media');
                $table->string('link_storage');
                $table->decimal('notation')->default(0);
                $table->timestamps();

                $table->foreignId('event_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('event_graphics');
    }
};
