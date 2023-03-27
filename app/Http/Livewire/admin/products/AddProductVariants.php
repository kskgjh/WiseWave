<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Variant;
use Livewire\Component;

class AddProductVariants extends Component
{
    public string $variantTitle;
    public int $type = 1;
    public int $variants = 2;

    protected $rules = [
        'variantTitle'=> 'required'
    ];

    public function render()
    {
        return view('livewire.admin.products.add-product-variants');
    }

    public function addVariant(){
        $this->variants++;
    }

    public function excludeVariant(){
        if ($this->variants == 2) return;
        $this->variants--;
    }

    public function submit(){
        $this->validate();

        $variant = new Variant([
            'title'=> $this->variantTitle,
        ]);


    }
}
