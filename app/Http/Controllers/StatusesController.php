<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
{
    /**
     * 在构造函数中引用auth权限认证中间件
     * 用户登录之后才有权进行该控制下的所有操作
     *
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户保存微博动态到数据库动作
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        session()->flash('success', '发布成功');
        return redirect()->back();
    }

    /**
     * 用户删除微博动态动作
     *
     * @param Status $status
     * 
     * @return [type]
     * 
     */
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已成功删除！');
        return redirect()->back();
    }
}
