<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class AuthorPersonalDetails extends Component
{
    public $author;
    public $name, $username, $email , $biography;

    public function mount()
    {
        $this->author = User::find(auth('web')->id());
        $this->name = $this->author->name;
        $this->username = $this->author->username;
        $this->email = $this->author->email;
        $this->biography = $this->author->biography;
    }

    public function UpdateDetails()
    {
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username,'.auth('web')->id()
        ],[
            'name.required' => 'Tên không được để trống',
            'username.required' => 'Username không được để trống'
        ]);

        User::where('id', auth('web')->id())->update([
            'name' => $this->name,
            'username' => $this->username,
            'biography' => $this->biography
        ]);

        $this->emit('updateAuthorProfileHeader');
        $this->emit('updateTopHeader');
        $this->showToastr('Thông tin của bạn đã được cập nhật thành công', 'success');
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
        return view('livewire.author-personal-details');
    }
}
