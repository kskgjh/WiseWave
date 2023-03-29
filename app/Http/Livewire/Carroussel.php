<?php

namespace App\Http\Livewire;

use App\Models\bannerImage;
use Livewire\Component;

class Carroussel extends Component
{
    public $imgs = [];
    public $current = 0;

    public function render()
    {
        $this->imgs = bannerImage::all();
        return view('livewire.carroussel');
    }


}
