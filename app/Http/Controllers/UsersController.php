<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        // 通过auth中间件，让指定的方法不需要登录验证就能访问
        $this->middleware('auth', [
            // 除了指定的动作（方法）不需要验证，其他都要
            'except' => ['show', 'create', 'store']
        ]);

        // 通过guest中间件，让游客只能访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    
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
    
    /**
     * 用户个人资料更新页面
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function edit(User $user)
    {
        // 使用模型访问策略控制访问控制器动作
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 用户个人修改资料入库
     *
     * @param User $user
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function update(User $user,Request $request)
    {
        // 使用模型访问策略控制访问控制器动作
        $this->authorize('update', $user);
        
        $this->validate($request, [
            'name' => 'required|max:50',
            // 修改字段验证的值可为nullable，当字段值为空时可以不用检验
            // 'password' => 'required|confirmed|min:6',
            'password' => 'nullable|confirmed|min:6'
        ]);

        // 根据用户输入的字段自动判定是否需要修改对应的字段
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        
        /* 
        // 手动更新用户输入的字段值
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);
         */
        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user);
    }
}
