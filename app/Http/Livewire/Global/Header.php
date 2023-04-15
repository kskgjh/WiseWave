<?php

namespace App\Http\Livewire\Global;

use App\Models\User;
use Livewire\Component;

class Header extends Component
{

    public function render()
    {
        $someUser = User::get()->first();
        return view('livewire.global.header', ['someUser'=> $someUser]);
    }

    
}
