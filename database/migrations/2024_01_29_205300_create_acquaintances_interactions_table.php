<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcquaintancesInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (DB::connection()->getDriverName() == 'mysql')
            Schema::create(config('acquaintances.tables.interactions', 'interactions'), function (Blueprint $table) {
                $table->id();

                $userModel = config('auth.providers.users.model');
                $userModel = (new $userModel);

                $userIdFkType = config('acquaintances.tables.interactions_user_id_fk_column_type');
                $table->{$userIdFkType}('user_id')->index();
                $table->morphs('subject');
                $table->string('relation')->default('follow')->comment('follow/like/subscribe/favorite/upvote/downvote');
                $table->double('relation_value')->nullable();
                $table->string('relation_type')->nullable();
                $table->timestamps();

                $table->foreign('user_id')
                    ->references($userModel->getKeyName())
                    ->on($userModel->getTable())
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (DB::connection()->getDriverName() == 'mysql')
            Schema::table(config('acquaintances.tables.interactions', 'interactions'), function ($table) {
                $table->dropForeign(config('acquaintances.tables.interactions', 'interactions') . '_user_id_foreign');
            });

        if (DB::connection()->getDriverName() == 'mysql')
            Schema::drop(config('acquaintances.tables.interactions', 'interactions'));
    }
}
