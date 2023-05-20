<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\URl;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // return route('login');
            if($request->routeIs('author.*')){
                session()->flash('fail', 'Bạn phải đăng nhập.');
                return route('author.login',['fail' => true,'returnURL' => URL::current()]);
            }

            if($request->routeIs('*')){
                session()->flash('fail','Bạn phải đăng nhập');
                return route('login',['fail'=>true,'returnUrl'=>URL::current()]);
            }
        }
    }   
}
