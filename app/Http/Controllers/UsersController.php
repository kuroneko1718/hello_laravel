<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 用户注册页面展示
     *
     * @return [type]
     * 
     */
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

    /**
     * 创建新用户，存入users数据表
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function store(Request $request)
    {
        // 使用验证器对request传来的用户输入的数据进行校验
        $this->validate($request, [
            'name' => 'required|max:50',
            // 对用户名进行长度校验
            // 'name' => 'min:3|max:5',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        // 把用户信息传入User模型写进数据表，并返回一个user实例
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // 获取用户输入的所有数据
        // $data = $request->all();
        
        // 把user实例传递给重定向路由
        // redirect()->route([$user->id]);

        // 用户创建之后使用Auth提供的login方法自动登录
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的路程~');
        return redirect()->route('users.show', [$user]);
    }
}
