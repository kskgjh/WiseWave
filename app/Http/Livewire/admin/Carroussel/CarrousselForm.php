<?php

namespace App\Http\Livewire\Admin\Carroussel;

use Livewire\Component;
use App\Models\bannerImage;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class CarrousselForm extends Component
{
    use WithFileUploads;

    public $image;
    protected $listeners = ['imgDeleted'=>'refreshImgs'];

    public function mount(){}

    public function uploadImg(){

        $this->validate([
            'image' => 'required',
        ]);

        $image = new bannerImage();

        $imageName = md5(Carbon::now()->timestamp). '.' .$this->image->extension();
        $this->image->storeAs('imgs/carroussel', $imageName);
        $image->imgName = $imageName;

        $image->save();

        session()->flash('message', 'A imagem foi enviada com sucesso');

        $this->image = null;

        $this->emit('imgSubmited');
    }



    public function render()
    {
        return view('livewire.admin.carroussel.carroussel-form');
    }
}
