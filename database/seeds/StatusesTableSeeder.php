<?php

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = ['1', '2', '3'];
        // 声明Faker类生成器
        // 通过 app() 方法获取一个faker容器的实例
        $faker = app(Faker\Generator::class);
        // 使用闭包函数传入faker实例和user_ids生成status模型随机实例假数据
        $statuses = factory(Status::class)->times(100)->make()->each(function($status) use ($faker, $user_ids) {
            // randomElement方法取出用户id组中任意一个元素赋值给status模型的user_id，使每个用户拥有不同数量的微博
            $status->user_id = $faker->randomElement($user_ids);
        });

        Status::insert($statuses->toArray());
    }
}
