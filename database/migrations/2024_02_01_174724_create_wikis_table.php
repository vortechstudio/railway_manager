<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('wikis', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('synopsis')->nullable();
                $table->longText('contenue');
                $table->boolean('posted');
                $table->timestamp('posted_at');
                $table->softDeletes();
                $table->timestamps();

                $table->foreignId('wiki_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('wiki_sub_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('wikis');
    }
};
