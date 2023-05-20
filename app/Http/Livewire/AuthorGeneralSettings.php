<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;

class AuthorGeneralSettings extends Component
{
    public $settings;
    public $blog_name, $blog_email, $blog_description;

    public function mount()
    {
        $this->settings = Setting::find(1);
        $this->blog_name = $this->settings->blog_name;
        $this->blog_email = $this->settings->blog_email;
        $this->blog_description = $this->settings->blog_description;
    }

    public function updateGeneralSettings()
    {
        $this->validate([
            'blog_name' => 'required',
            'blog_email' => 'required|email'
        ],[
            'blog_name.required' => 'Tên trang web không được để trống',
            'blog_email.required' => 'Email không được để trống',
            'blog_email.email' => 'Email không hợp lệ'
        ]);

        $update = $this->settings->update([
            'blog_name' => $this->blog_name,
            'blog_email' => $this->blog_email,
            'blog_description' => $this->blog_description
        ]);

        if($update){
            $this->showToastr('Cập nhật cài đặt chung thành công','success');
            $this->emit('updateAuthorFooter');
        }else{
            $this->showToastr('Cập nhật thất bại','error');
        }
    }

    // sử dụng dispatchBrowserEvent để phát ra sự kiện showToastr
    public function showToastr($message, $type){
        return $this->dispatchBrowserEvent('showToastr',[
            'type' => $type,
            'message' => $message
        ]);
    }


    public function render()
    {
        return view('livewire.author-general-settings');
    }
}
