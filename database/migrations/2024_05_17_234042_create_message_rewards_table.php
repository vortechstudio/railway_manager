<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql')->create('message_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('reward_type');
            $table->bigInteger('reward_value');
            $table->integer('reward_item_id')->unsigned()->nullable()->comment("ID de l'objet si lié à un objet dans reward_type");

            $table->foreign('message_id');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('message_rewards');
    }
};
