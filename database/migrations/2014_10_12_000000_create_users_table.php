<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->integer('city_id')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->date('date_of_exit')->nullable();
            $table->string('is_employee')->default('0');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('status')->default(0);
            $table->text('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['name' => 'admin','dob' => '2000-10-10','email' => 'owaisimam2@gmail.com','password' => Hash::make('12345678'),'email_verified_at' => '2022-01-02 17:04:58','avatar' => 'images/avatar-1.jpg','created_at' => now(),]);
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