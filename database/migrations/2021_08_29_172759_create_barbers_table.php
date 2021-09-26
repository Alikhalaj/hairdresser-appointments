<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->id();
            $table->string('name_shop');
            $table->string('phone');
            $table->bigInteger('user_id')->unsigned();
            $table->text('address');
            $table->string('time_work_start');
            $table->string('time_work_end');
            $table->string('image_business_license');
            $table->string('image_hairdressing_degree');
            $table->double('latitude');
            $table->double('longitude');
            $table->boolean('suggest');
            $table->boolean('offer');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barbers');
    }
}
