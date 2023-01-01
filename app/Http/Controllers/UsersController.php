<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        // 通过auth中间件，让指定的方法不需要登录验证就能访问
        $this->middleware('auth', [
            // 除了指定的动作（方法）不需要验证，其他都要
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        // 通过guest中间件，让游客只能访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * 所有用户展示
     *
     * @return [type]
     * 
     */
    public function index()
    {
        // User用户模型分页器展示
        $users = User::paginate(6);
        return view('users.index', compact('users'));
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

        // 修改用户注册登录逻辑，需要通过邮箱验证之后才能正常使用账户
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送至您的邮箱上，请注意查收。');
        return redirect('/');

        // 用户创建之后使用Auth提供的login方法自动登录
        // Auth::login($user);
        // session()->flash('success', '欢迎，您将在这里开启一段新的路程~');
        // return redirect()->route('users.show', [$user]);
    }

    /**
     * 用户注册邮箱验证动作
     *
     * @param mixed $token
     * 
     * @return [type]
     * 
     */
    public function confirmEmail($token)
    {
        // 根据用户模型初始化创建的token查找邮箱激活用户
        $user = User::where('activation_token', $token)->firstOrFail();

        // 更新用户邮箱激活字段
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        // 用户权限登录
        Auth::login($user);
        // 提示信息写入session传递给前台页面模板
        session()->flash('success', '邮箱验证成功，现在已为你自动登录~');
        // 重定向路由到用户个人信息页面
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

    /**
     * 删除用户
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    /**
     * 用户注册邮件发送
     *
     * @param User $user
     * 
     * @return [type]
     * 
     */
    protected function sendEmailConfirmationTo(User $user)
    {
        // 构造发送邮件的必要参数：邮件激活视图 $view，用户实例 $user，邮件发送者信息 $from, $name，邮件接收人信息 $to，邮件主题 $subject
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = '感谢注册 Weibo App 应用！请确认你的邮箱。';

        // 使用Mail发送激活邮件，使用闭包函数构造邮件信息并发送
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name) ->to($to) ->subject($subject);
        });
    }
}
