<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('photoUrl');
            $table->string('thumbUrl');
            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->string('info', 60);
            $table->string('position', 50);
            $table->string('vk');
            $table->string('facebook');
            $table->string('skype', 60);
            $table->string('twitter', 60);
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
        Schema::dropifExists('people');
    }
}
