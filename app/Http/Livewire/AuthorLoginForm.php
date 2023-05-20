<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthorLoginForm extends Component
{
    public $login_id, $password;
    public $returnUrl;

    public function mount()
    {
        $this->returnUrL = request()->returnURL;
    }

    public function LoginHandler()
    {
        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $this->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5'
            ], [
                    'login_id.required' => 'Email hoặc Username không được để trống',
                    'login_id.email' => 'Địa chỉ email không hợp lệ',
                    'login_id.exists' => 'Email không tồn tại',
                    'password.required' => 'Password không được để trống'
                ]);
        } else {
            $this->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5'
            ], [
                    'login_id.required' => 'Email hoặc Username không được để trống',
                    'login_id.exists' => 'Username không tồn tại',
                    'password.required' => 'Password không được để trống'
                ]);
        }

        $creds = array($fieldType => $this->login_id, 'password' => $this->password);

        if (Auth::guard('web')->attempt($creds)) {
            $checkUser = User::where($fieldType, $this->login_id)->first();
            if ($checkUser->type == 3) {
                Auth::guard('web')->logout();
                return redirect()->route('author.login')->with('fail', 'Tài khoản không được quyền đăng nhập');
            } else {
                if ($checkUser->blocked == 1) {
                    Auth::guard('web')->logout();
                    return redirect()->route('author.login')->with('fail', 'Tài khoản của bạn đã bị khóa');
                } else {
                    // return redirect()->route('author.home');
                    if ($this->returnUrl != null) {
                        return redirect()->to($this->returnUrl);
                    } else {
                        redirect()->route('author.home');
                    }
                }
            }


        } else {
            session()->flash('fail', 'Email hoặc mật khẩu không chính xác');
        }

        // $this->validate([
        //     'email'=> 'required|email|exists:users,email',
        //     'password' => 'required|min:5'
        // ],[
        //     'email.required' => 'Enter your email address',
        //     'email.email' => 'Invalid email address',
        //     'email.exists' => 'This email is not registered in database',
        //     'password.required' => 'Password is required'
        // ]);

        // $creds = array('email' => $this->email, 'password' => $this->password);
        // if(Auth::guard('web')->attempt($creds)){
        //     $checkUser = User::where('email', $this->email)->first();
        //     if($checkUser->blocked == 1){
        //         Auth::guard('web')->logout();
        //         return redirect()->route('author.login')->with('fail','Your account had been blocked');
        //     }else{
        //         return redirect()->route('author.home');
        //     }

        // }else{
        //     session()->flash('fail','Incorrect email or password');
        // }
    }

    public function render()
    {
        return view('livewire.author-login-form');
    }
}