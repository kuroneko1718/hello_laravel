<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id')->comment('用户微博动态主键id，自增');
            // 添加微博动态关联用户id并建立索引
            $table->integer('user_id')->index()->comment('微博动态关联用户id');
            $table->text('content')->comment('微博动态内容');
            // 为微博动态创建时间添加索引，方便根据创建时间进行倒序展示
            $table->index(['created_at']);
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
        Schema::dropIfExists('statuses');
    }
}
