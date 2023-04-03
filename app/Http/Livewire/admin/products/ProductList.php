<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\WithPagination;
use App\Models\productImg;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductList extends Component
{
    use WithPagination;
    protected $listeners = ['productCreated' => 'render',
                             'delSelected'=> 'delSelected'];
    public Collection $variants;

    public function delSelected(array $ids){
        foreach($ids as $id){
            productImg::where('product_id', $id)->delete();
        }
        Product::whereIn('id', $ids)->delete();
        
    }

    public function mount(){
        $this->variants = Variant::all();
    }

    public function render()
    {
        $products = Product::with('productImgs')
                ->paginate(20);
        return view('livewire.admin.products.product-list', ['products'=> $products]);
    }


}
