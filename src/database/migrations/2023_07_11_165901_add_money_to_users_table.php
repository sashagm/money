<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn(config('money.user_table'), config('money.money_colum'))) {
            Schema::table(config('money.user_table'), function (Blueprint $table) {
                $table->decimal(config('money.money_colum'), 10, 2)->after(config('money.after_colum'))->default(0.00);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn(config('money.user_table'), config('money.money_colum'))) {
            Schema::table(config('money.user_table'), function (Blueprint $table) {
                $table->dropColumn(config('money.money_colum'));
            });
        }
    }
};
