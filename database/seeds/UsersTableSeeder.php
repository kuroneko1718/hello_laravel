<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * users表数据填充文件
 * php artisan make:seeder UsersTableSeeder
 * 创建数据表数据填充文件后，还需要运行填充文件才会生效到数据库（重置数据和填充数据）
 * php artisan migrate:refresh --seed
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 使用模型工厂填充数据，创建模型，快速填充50条模拟数据到users数据表
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        // 从Users模型中查找出id为1的用户，并修改用户字段值并保存到数据表中
        $user = User::find(1);
        $user->name = 'Summer';
        $user->email = 'summer@example.com';
        $user->password = bcrypt('qwe123');
        $user->is_admin = true;
        $user->save();
    }
}
