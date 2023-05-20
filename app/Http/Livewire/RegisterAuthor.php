<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Mail;


class RegisterAuthor extends Component
{
    public $username, $fullname, $password,$confirm_password,$email;

    public function render()
    {
        return view('livewire.register-author');
    }
    public function mount(){
        $this->returnUrL = request()->returnURL;
    }

    public function RegisterHandler(){
        $this->validate([
            'username' => 'required|unique:users,username|min:10',
            'email' => 'Required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'same:password',
            'fullname' => 'required'

        ], [
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có từ 5 ký tự trở lên',
                'confirm_password.same' => 'Mật khẩu xác nhập không trùng',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại',
                'fullname.required' => "Họ và tên không được để trống",
                'username.required' => 'username không được để trống',
                'username.unique' => 'Username đã tồn tại',
                'username.min' => 'Username phải từ 10 kí tự trở lên'
            ]);

            $token = Str::random(10);
            $authorregis = new User();
            $authorregis->name = $this->fullname;
            $authorregis->email = $this->email;
            $authorregis->username = $this->username;
            $authorregis->password = bcrypt($this->confirm_password);
            $authorregis->blocked = 1;
            $authorregis->type = 2;
            $authorregis->remember_token = $token;
            $save = $authorregis->save();
            $data = array(
                'name' => $this->fullname,
                'email' => $this->email,
                'token' => $token,
                'url' => route('author.login'),
    
            );
    
            $author_email = $this->email;
            $author_name = $this->fullname;
            if ($save) {
                Mail::send('new-author-active', $data, function ($message) use ($author_email, $author_name) {
                    $message->from('huynhhuy12149@gmail.com', 'LaraBlog');
                    $message->to($author_email, $author_name)
                        ->subject('Account Creation');
                });
                session()->flash('success', 'Tài khoản của bạn đã được tạo thành công vui lòng kích hoạt.');
                return redirect()->route('author.login');
            }else{
                session()->flash('fail', 'Tài khoản của bạn không được tạo.');
                return redirect()->route('author.register');
            }
    }


}
