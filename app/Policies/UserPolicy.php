<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * 启用模型、控制器动作访问策略
     *
     * @param User $currentUser
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function update(User $currentUser, User $user)
    {
        // 自动验证当前账户和授权用户动作的id是否一致
        return $currentUser->id === $user->id;
    }
}
