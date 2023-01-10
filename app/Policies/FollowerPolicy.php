<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 定义用户关注的访问策略
     * 用户自己不能关注自己本身
     *
     * @param User $currentUser
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function follow(User $currentUser, User $user)
    {
        // 判断当前用户id和Auth::user用户模型id是否一致
        return $currentUser->id !== $user->id;
    }
}
