<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 获取去除掉 ID 为 1 的所有用户 ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 让 id 为 1 的用户关注除了 id 为 1 的所有用户
        $user->follow($follower_ids);

        // 让其他 id 不为 1 的用户来关注 id 为 1 的用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
