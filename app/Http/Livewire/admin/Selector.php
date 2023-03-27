<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Selector extends Component
{
    public string $currentContent = 'products';
    protected $listeners = [
        "selectContent" => 'selectContent',
    ];

    public function render()
    {
        return view('livewire.admin.selector');
    }

    public function selectContent($string) {
        $this->currentContent = $string;

    }
}
