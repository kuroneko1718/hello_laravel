<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    /**
     * 展示用户登录页面
     *
     * @return [type]
     * 
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 验证用户信息
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function store(Request $request)
    {
        // 使用验证器对用户输入进行校验
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        // 验证器校验之后再使用Auth类对用户于users数据表进行校验
        // Auth::attempt(['email' => $email, 'password' => $password])
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登录成功之后的动作
            session()->flash('success', '欢迎回来~');
            // 使用Auth类获取验证过后的用户模型实例
            return redirect()->route('users.show', [Auth::user()]);
        }
        else {
            // 登录失败之后的动作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            // 重定向withInput方法，重定向会登录页面是使用模板的old方法不用重写输入表单
            return redirect()->back()->withInput();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
