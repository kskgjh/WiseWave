<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class SideBar extends Component
{
    public int $hidden = 1;
    public string $selected = 'overview';

    public function render()
    {
        return view('livewire.admin.side-bar');
    }

    public function switchSideBar(){

        if ($this->hidden === 0) {
            return $this->hidden = 1;
        }
        $this->hidden = 0;

    }
    public function sendEmit($string) {
        $this->selected = $string;
        $this->emit('selectContent', $string);
    }
}
