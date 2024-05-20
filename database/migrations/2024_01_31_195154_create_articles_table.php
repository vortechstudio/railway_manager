<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('news');
            $table->string('description')->nullable();
            $table->longText('contenue');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('publish_social')->default(false);
            $table->timestamp('publish_social_at')->nullable();
            $table->boolean('promote')->default(false);
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->foreignId('author')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('cercle_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('articles');
    }
};
