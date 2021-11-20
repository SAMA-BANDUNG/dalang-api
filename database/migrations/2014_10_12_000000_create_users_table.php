<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone_number', 20);
            $table->date('date_of_birth');
            $table->string('avatar')->nullable();
            $table->text('address');
            $table->string('langitude');
            $table->string('longitude');
            $table->timestamp('account_verified_at')->nullable();
            $table->string('phone_type')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('fcm_token')->nullable();
            $table->tinyInteger('user_type')->comment('0:Super Admin, 1:User, 2:Vendor')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
