<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthorResetForm extends Component
{
    public $email, $token, $new_password, $confirm_new_password;

    public function mount()
    {
        $this->email = request()->email;
        $this->token =  request()->token;
    }

    public function ResetHandler()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|min:5',
            'confirm_new_password' => 'same:new_password'
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.exists' => 'Email không tồn tại',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.min' => 'Số ký tự tối thiểu phải là 5',
            'confirm_new_password' => 'Xác nhận mật khẩu mới và mật khẩu mới phải trùng khớp'
        ]);

        $check_token = DB::table('password_resets')->where([
            'email' => $this->email,
            'token' => $this->token,
        ])->first();

        if(!$check_token){
            session()->flash('fail','Mã token không hợp lệ');
        }else {
            User::where('email', $this->email)->update([
                'password' => Hash::make($this->new_password)
            ]);
            DB::table('password_resets')->where([
                'email'=>$this->email
            ])->delete();

            $success_token = Str::random(64);
            session()->flash('succcess','Mật khẩu của bạn đã được cập nhật thành công. Đăng nhập bằng email của bạn và mật khẩu mới của bạn');

            $this->redirectRoute('author.login',['tkn' => $success_token, 'UEmail' => $this->email]);
        }
    }

    public function render()
    {
        return view('livewire.author-reset-form');
    }
}
