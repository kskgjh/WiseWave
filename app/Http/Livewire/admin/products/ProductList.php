<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\WithPagination;
use App\Models\productImg;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductList extends Component
{
    use WithPagination;
    protected $listeners = ['productCreated' => 'render',
                             'delSelected'=> 'delSelected'];
    public string $msg;
    public bool $modal = false;

    public function toggleModal(){
        $this->modal = false;
    }

    public function delSelected(array $ids){
        foreach($ids as $id){
            productImg::where('product_id', $id)->delete();
        }
        Product::whereIn('id', $ids)->delete();
        
    }

    public function render()
    {
        $products = Product::with('productImgs')
                ->paginate(20);
        return view('livewire.admin.products.product-list', ['products'=> $products]);
    }


}
