<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Header extends Component
{

    public function render()
    {
        $someUser = User::get()->first();
        return view('livewire.header', ['someUser'=> $someUser]);
    }

    
}
