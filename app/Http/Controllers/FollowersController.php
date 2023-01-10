<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    /**
     * 构造函数判读是否登录，登录之后才有权执行该控制下所有动作
     */
    public function __construct()
    {
        // 使用auth中间件判断用户是否登录 
        $this->middleware('auth');
    }
    
    /**
     * 用户关注动作
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function store(User $user)
    {
        // 使用权限认证器读取policy对应的判断是否有权执行以下动作
        $this->authorize('follow',$user);
        // 当前登录用户用Auth::user()获取
        // $user为表单传递的用户参数
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 用户取消关注动作
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function destroy(User $user)
    {
        $this->authorize('follow', $user);
        // 当前登录用户用Auth::user()获取
        // $user为表单传递的用户参数
        // 使用User模型判断用户是否已经关注了
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }
}
