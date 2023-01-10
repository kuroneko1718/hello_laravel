<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    /**
     * 首页展示
     *
     * @return [type]
     * 
     */
    public function home()
    {
        // 判断用户是否已经登录，如果登录则获取首页的微博动态展示
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home', compact('feed_items'));
    }

    /**
     * 帮助页展示
     *
     * @return [type]
     * 
     */
    public function help()
    {
        return view('static_pages/help');
    }

    /**
     * 有关信息页面展示
     *
     * @return [type]
     * 
     */
    public function about()
    {
        return view('static_pages/about');
    }
}
