<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('post_comments', function (Blueprint $table) {
                $table->id();
                $table->longText('comment');
                $table->softDeletes();
                $table->timestamps();

                $table->foreignId('post_id')
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
            Schema::connection('mysql')->dropIfExists('post_comments');
    }
};
