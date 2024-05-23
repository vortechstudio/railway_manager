<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('post');
            $table->string('visibility')->default('public');
            $table->boolean('commentable')->default(true);
            $table->string('type')->default('text');
            $table->boolean('published')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('posts');
    }
};
