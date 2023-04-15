<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\productImg;
use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public function submit(){

        $this->validate();
        $product = new Product([
            'name'=> $this->name,
            'amount'=> $this->amount,
            'status'=> $this->status,
            'value'=> $this->value,
            'text'=> $this->text,
            'variants_id'=> $this->variant
        ]);

        if($product->save()){
            $imagesArr = [];
            foreach ($this->images as $image){

                $imageName = uniqid() .'.'. $image->extension();
                    if($image->storeAs('imgs/product', $imageName)) {

                    $imgDone = new productImg([
                        'name'=> $imageName,
                        'product_id'=> $product->id,
                    ]);
                        if(!$imgDone->save()){
                            session()->flash("imageError", "Falha ao salvar uma imagem, por favor confirme na página do produto");
                        }
                        array_push($imagesArr, $imgDone);
                }
            }
            $this->emit('productCreated');
            $this->dispatchBrowserEvent('add-product', ['product'=> $product, 'images'=> $imagesArr]);
            session()->flash('productCreated', 'Produto cadastrado com sucesso');
            $this->standart();
}
        
}
    public function render()
    {
        return view('livewire.admin.products.product-form');
    }
}
