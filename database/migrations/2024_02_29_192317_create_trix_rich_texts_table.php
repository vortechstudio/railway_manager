<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrixRichTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::connection()->getDriverName() == 'mysql')
            Schema::create('trix_rich_texts', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->autoIncrement();
                $table->string('field');
                $table->morphs('model');
                $table->text('content')->nullable();
                $table->timestamps();
            });

        if (DB::connection()->getDriverName() == 'mysql')
            Schema::create('trix_attachments', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->autoIncrement();
                $table->string('field');
                $table->unsignedInteger('attachable_id')->nullable();
                $table->string('attachable_type');
                $table->string('attachment');
                $table->string('disk');
                $table->boolean('is_pending')->default(1);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::connection()->getDriverName() == 'mysql') {
            Schema::drop('trix_attachments');
            Schema::drop('trix_rich_texts');
        }
    }
}
