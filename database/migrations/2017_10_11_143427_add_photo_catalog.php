<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photocats', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name', 60);
            $table->string('slug', 60);
            $table->string('folder');
            $table->string('picture');
            $table->string('thumb');
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
        Schema::dropIfExists('photocats');
    }
}
