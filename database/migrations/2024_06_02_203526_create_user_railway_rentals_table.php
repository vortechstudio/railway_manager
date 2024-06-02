<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_railway_rentals', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_contract');
            $table->integer('duration_contract');
            $table->decimal('amount_paid', 16);
            $table->decimal('amount_caution', 16);
            $table->decimal('amount_fee', 16);
            $table->string('status');
            $table->foreignId('user_id');
            $table->foreignId('railway_rental_id');
            $table->foreignId('user_railway_engine_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_railway_rentals');
    }
};
