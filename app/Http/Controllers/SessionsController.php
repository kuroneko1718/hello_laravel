<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {        
        // 通过guest中间件，让游客只能访问注册登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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
            
            $fallback = route('users.show', Auth::user());
            // 使用Auth类获取验证过后的用户模型实例
            // return redirect()->route('users.show', [Auth::user()]);
            return redirect()->intended($fallback);
        }
        else {
            // 登录失败之后的动作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            // 重定向withInput方法，重定向会登录页面是使用模板的old方法不用重写输入表单
            return redirect()->back()->withInput();
        }
    }

    /**
     * 用户退出登录动作
     *
     * @return [type]
     * 
     */
    public function destroy()
    {
        // Auth类用户退出方法
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
