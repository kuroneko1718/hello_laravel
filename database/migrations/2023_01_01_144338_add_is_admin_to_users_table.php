<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * users数据表迁移文件，为users表添加表字段is_admin
 * php artisan make:migration add_is_admin_to_users_table --table=users
 * 创建数据表迁移文件之后，还有再运行数据表迁移文件，才会生效到数据库中
 * php artisan migrate
 */
class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 为数据表users新增字段is_admin
        Schema::table('users', function (Blueprint $table) {
            // 声明字段is_admin为boolean类型，默认为false
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 回滚数据库操作，删除数据表users is_admin字段
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
