<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_advantage_cards', function (Blueprint $table) {
                $table->id();
                $table->string('class');
                $table->string('type');
                $table->string('description');
                $table->integer('qte');
                $table->integer('tpoint');
                $table->decimal('drop_rate')->default(90);
                $table->bigInteger('model_id')->unsigned()->nullable();
                $table->string('name_function')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_advantage_cards');
    }
};
