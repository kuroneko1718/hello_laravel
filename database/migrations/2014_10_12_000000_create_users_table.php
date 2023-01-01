<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
/*         Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
 */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('用户表主键，自增id');
            $table->string('name')->comment('用户名');
            $table->string('email')->unique()->comment('用户邮箱：唯一性约束');
            $table->timestamp('email_verified_at')->nullable()->comment('邮箱验证时间');
            $table->string('password', 60)->comment('用户密码');
            $table->rememberToken()->comment('用户token，用于记住登录状态');
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
        Schema::dropIfExists('users');
    }
}
