<?php

use Faker\Generator as Faker;

// 定义Status模型的工厂实例，在seeder中需要使用该模型的工厂实例生成status模型的随机工厂实例
$factory->define(App\Models\Status::class, function (Faker $faker) {
    // 生成随机timestamp格式的时间字段
    $date_time = $faker->date . ' ' . $faker->time;
    
    return [
        'content' => $faker->text,
        'created_at' => $date_time,
        'updated_at' => $date_time
    ];
});
