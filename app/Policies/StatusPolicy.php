<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
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
     * 定义用户删除动态访问策略
     * 只有属于用户自己发布的微博动态才能有删除权利
     *
     * @param User $user
     * @param Status $status
     * 
     * @return [type]
     * 
     */
    public function destroy(User $user,  Status $status)
    {
        // 判断Auth::user用户模型和微博动态模型的user_id是否一致
        return $user->id === $status->user_id;
    }
}
