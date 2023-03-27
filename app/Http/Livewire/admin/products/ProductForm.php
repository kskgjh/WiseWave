<?php

namespace App\Http\Livewire\Admin\Products;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\File;
use App\Rules\ProductValueRule;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use App\Models\productImg;
use App\Models\Product;
use App\Models\Variant;
use Livewire\Component;
use Manny\Manny;

class ProductForm extends Component
{
    use WithFileUploads;

    public string $message = '';
    public string $name = '';
    public string $value = '';
    public string $text = '';
    public $images = [];
    public string $amount = '0';
    public bool $status = true;
    public $variant;
    public int $inputCount = 1;
    public int $imgIndex = 0;
    public Collection $variants;
    public int $modal = 0;

    public $messages = [
        'name.required'=> 'Por favor, insira um nome para o produto.',
        'name.unique'=> 'Já existe um produto com esse nome.',
        'images.required'=> 'Por favor, insira pelo menos uma imgaem.',
        'value.required'=> 'Por favor, insira um preço.'
    ];
    
    public function rules(){
        return [
            'name' => ['required', 'unique:products,name'],
            'value'=> [new ProductValueRule, 'required'],
            'images'=> ['required']
        ];
    }

    public function updated($field){
        if($field == 'value') {
            $this->value = strrev(Manny::mask(strrev($this->value), '11,111.111.111.111.111.111.111'));
        }

        if($field == 'images'){
            $this->inputCount = count($this->images) + 1;

            }
        
        if($field == 'name'){
            $this->validateOnly($field);
        }

        if(session()->has('variantCreated')){
            $this->refreshVariants();
            session()->forget('variantCreated');
        }
    }

    public function mount(){
        $this->refreshVariants();

    }

    public function refreshVariants(){
        $this->variants = Variant::get();
    }

    public function modal($string, $index){
        if ($string == 'deleteImg'){
            $this->message = "Tem certeza que deseja excluir essa imagem?";
            $this->modal = 1;
            $this->imgIndex = $index;
        }
    }

    public function closeModal(){
        $this->modal = 0;
        unset($this->message);
    }

    public function deleteImg($index){
        unset($this->images[$index]);
        $this->inputCount--;
        $this->images = array_values($this->images);
        $this->closeModal();
    }

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

                $imageName = md5(Carbon::now()->timestamp) .'.'. $image->extension();
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

    public function standart(){
        $this->resetExcept('variants');
    }

    public function render()
    {
        return view('livewire.admin.products.product-form');
    }
}
