<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovingsTable extends Migration
{
    public function up()
    {
        Schema::create('movings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('moving_from');
            $table->string('moving_to');
            $table->date('moving_date');
            $table->longText('comments')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->datetime('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
