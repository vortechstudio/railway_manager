<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('title');
            $table->string('description')->nullable();
            $table->longText('contenue');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('publish_social')->default(false);
            $table->timestamp('publish_social_at')->nullable();
            $table->timestamps();

            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_versions');
    }
};
