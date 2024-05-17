<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_gares', function (Blueprint $table) {
                $table->id();
                $table->uuid();
                $table->string('name');
                $table->string('type');
                $table->string('latitude');
                $table->string('longitude');
                $table->string('city');
                $table->string('pays');
                $table->string('freq_base');
                $table->string('hab_city');
                $table->json('transports')->nullable();
                $table->json('equipements')->nullable();
                $table->softDeletes();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_gares');
    }
};
