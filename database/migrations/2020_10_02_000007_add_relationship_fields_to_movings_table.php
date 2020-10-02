<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMovingsTable extends Migration
{
    public function up()
    {
        Schema::table('movings', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_2312361')->references('id')->on('users');
        });
    }
}
