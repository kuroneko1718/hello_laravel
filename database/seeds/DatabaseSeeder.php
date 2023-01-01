<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // php artisan migrate:refresh --seed 
        // 声明自动调用的需要用到的数据填充类
        $this->call([
            // users表数据填充类，如果这里没有声明，则需要使用命令手动调用数据填充类
            // php artisan db:seed --class=UsersTableSeeder
            UsersTableSeeder::class
        ]);
    }
}
