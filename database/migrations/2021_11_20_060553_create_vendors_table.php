<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('phone_office', 20);
            $table->text('description');
            $table->text('address');
            $table->string('langitude');
            $table->string('longitude');
            $table->tinyInteger('status')->comment('0: Pending, 1:Verified, 2:Banned')->default(0);
            $table->string('photo_1');
            $table->string('photo_2')->nullable();
            $table->string('photo_3')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('vendors');
    }
}
