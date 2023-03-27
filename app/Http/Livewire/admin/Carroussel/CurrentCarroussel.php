<?php

namespace App\Http\Livewire\Admin\Carroussel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\bannerImage;
use Livewire\Component;

class CurrentCarroussel extends Component
{
    public Collection $images;
    public int $currentMain = 0;
    protected $listeners = ['imgSubmited'=> 'refreshImgs'];

    public function refreshImgs(){
        $this->images = bannerImage::all()->fresh();
    }

    public function mount(){
        $this->images = bannerImage::all();

    }

    public function render()
    {
        return view('livewire.admin.carroussel.current-carroussel');
    }

    public function changeImg($index){
        
        $this->currentMain = $index;
    }

    public function deleteThis(){
        Storage::delete("imgs/carroussel/".$this->images[$this->currentMain]->imgName);
        bannerImage::destroy($this->images[$this->currentMain]->id);


    if (!isset($images[$this->currentMain]) && $this->currentMain += -1 !== -1) {
            $this->currentMain += -1;
}
        $this->emit('startModal');

        $this->images = bannerImage::all();

    }
}
