<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type_event')->default(\App\Enums\Social\EventTypeEnum::POLL);
            $table->string('synopsis');
            $table->longText('contenue');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->string('status')->default(\App\Enums\Social\EventStatusEnum::PROGRESS);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
