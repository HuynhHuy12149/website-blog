<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorChangePasswordForm extends Component
{
    public $current_password, $new_password, $confirm_new_password;

    public function changePassword()
    {
        $this->validate([
            'current_password' => [
                'required', function($attribute, $value, $fail){
                    if(!Hash::check($value, User::find(auth('web')->id())->password)){
                        return $fail(__('Mật khẩu hiện tại không chính xác'));
                    }
                }
            ],
            'new_password' => 'required|min:5|max:25',
            'confirm_new_password' => 'same:new_password'
        ],[
            'current_password.required' => 'Mật khẩu không được để trống',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.min' => 'Số ký tự tối thiểu phải là 5',
            'new_password.max' => 'Số ký tự tối đa không quá 25',
            'confirm_new_password' => 'Xác nhận mật khẩu mới và mật khẩu mới phải trùng khớp'
        ]);

        $query = User::find(auth('web')->id())->update([
            'password' => Hash::make($this->new_password)
        ]);

        if($query){
            $this->showToastr('Mật khẩu của bạn cập nhật thành công','success');
            $this->current_password = $this->new_password = $this->confirm_new_password = null;
        }else{
            $this->showToastr('Có gì đó sai');
        }
    }

    public function showToastr($message, $type){
        return $this->dispatchBrowserEvent('showToastr',[
            'type' => $type,
            'message' => $message
        ]);
    }

    public function render()
    {
        return view('livewire.author-change-password-form');
    }
}
