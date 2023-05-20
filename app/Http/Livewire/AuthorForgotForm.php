<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthorForgotForm extends Component
{
    public $email;
    public function ForgotHandler()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email'
        ], [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'email.exists' => 'Email không tồn tại'
            ]);
        $type = User::where('email', $this->email)->first();
        if ($type->type == 1 || $type->type == 2 || $type->type == 4) {
            $token = base64_encode(Str::random(64));
            DB::table('password_resets')->insert([
                'email' => $this->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            $user = User::where('email', $this->email)->first();
            $link = route('author.reset-form', ['token' => $token, 'email' => $this->email]);
            $body_message = "Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản được liên kết với " . $this->email . ".<br> Bạn có thể đặt lại mật khẩu của mình bằng cách nhấp vào nút bên dưới.";
            $body_message .= '<br>';
            $body_message .= '<a href="' . $link . '" target="_blank" style="color:#FFF;border-color:#22bc66;border-style:solid;border-width:10px 180px; background-color:#22bc66;display:inline-block;text-decoration:none;border-radius:3px;box-shadow:0 2px 3px rgba(0,0,0,0.16);-webkit-text-size-adjust:none;box-sizing:border-box">Đặt lại mật khẩu</a>';
            $body_message .= '<br>';
            $body_message .= 'Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này';

            $data = array(
                'name' => $user->name,
                'body_message' => $body_message
            );

            // Mail::send('forgot-email-template', $data, function($message) use($user){
            //     $message->from('huynhhuy12149@gmail.com','laraBlog');
            //     $message->to($user->email, $user->name)->subject('Reset password');
            // });

            Mail::send('forgot-email-template', $data, function ($message) use ($user) {
                $message->from('huynhhuy12149@gmail.com', 'Larablog');
                $message->to($user->email, $user->name)->subject('Reset Password');


            });

            $this->email = null;
            session()->flash('success', 'Chúng tôi đã gửi email chứa đường link đặt lại mật khẩu của bạn');

        } else {
            session()->flash('success', 'Bạn không có quyền tại trang này');
        }

    }

    public function render()
    {
        return view('livewire.author-forgot-form');
    }
}