<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class Home extends Component
{
    public $author;
    public function mount(){
        $this->author = User::find(auth('web')->id());
    }
    public function render()
    {   
        return view('livewire.home');
    }

}
