<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_subject');
            $table->longText('message_content');
            $table->string('message_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
