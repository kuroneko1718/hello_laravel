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
     * 启用模型、控制器动作（用户更新个人资料）访问策略
     * 用户修改资料需要为自身才能修改成功（用户需要为自身才能访问update动作）
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
    
    /**
     * 删除用户动作访问策略
     * 当用户为管理员且用户id不为自身（管理员本身用户也不能删除自己）
     *
     * @param User $currentUser
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
