<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户个人信息展示
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function show(User $user)
    {
        // compact方法将数据绑定到视图
        return view('users.show', compact('user'));
    }
}
