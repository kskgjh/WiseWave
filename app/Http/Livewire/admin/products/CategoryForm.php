<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Component;

class CategoryForm extends Component
{
    public Collection $categories;

    public function mount(){
        $this->categories = Category::where('type', 'parent')->get();
    }

    public function render()
    {
        return view('livewire.admin.products.category-form');
    }
}
