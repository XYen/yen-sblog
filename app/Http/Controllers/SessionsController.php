<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' =>'required'
            ]); //credentials 认证

        if (Auth::attempt($credentials,$request->has('remember'))) {
            session()->flash('success','欢迎回来！');
            return redirect()->route('users.show',[Auth::user()]);
            # store 方法内使用了 Laravel 提供的 Auth::user() 方法来获取 当前登录用户 的信息，并将数据传送给路由。
        }else {
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配！');
            return redirect()->back();
        }

        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}