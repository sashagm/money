<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(config('transfer.userTable'));
            $table->string('desc')->nullable();
            $table->decimal('summa', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('bonus', $precision = 10, $scale = 2)->nullable();
            $table->string('initid')->nullable();
            $table->tinyInteger('provider')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}