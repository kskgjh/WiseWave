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
    public Collection $variants;
    public $msg;
    public int $currentPage;

    public function mount(){
        $this->variants = Variant::all();
        
    }
    public function render()
    {
        $products = Product::with('productImgs')->paginate(20);
        $this->currentPage = $products->currentPage();


        return view('livewire.admin.products.product-list', ['products'=> $products]);
    }


}
