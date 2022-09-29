<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('users.login');
    }

    /**
     * Форма авторизации
     * @param LoginValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost(LoginValidation $request)
    {
        if(Auth::attempt($request->validated()))
        {
            $request ->session()->regenerate();
            return back()->with(['success' => 'true']);
        }
        return back()->withErrors(['auth' => 'Логин или пароль неверный!']);
    }

    /**
     * Получение данных с формы авторизации через Post запрос
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('users.register');
    }

    /**
     * Получение данных с формы регистрации через post запрос
     * Форма регистрации
     * @param RegisterValidation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerPost(RegisterValidation $request)
    {
        $requests =
        $request->merge(['password' => Hash::make($request->password)]);
        User::create($request->validated());
        return redirect()->route('login')->with(['register' => true]);
    }
}