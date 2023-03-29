<div class="main">
    @switch($currentContent)
    @case('carroussel')        
    <div>
        @livewire('admin.carroussel.carroussel-form')
        @livewire('admin.carroussel.current-carroussel')
    </div>
    @break
    @case('products')
    <div class="productsForms">
        @livewire('admin.products.product-form')
        <div class="rightSide">
            @livewire('admin.products.variants-form')
            @livewire('admin.products.category-form')
        </div>
    </div>
        @livewire('admin.products.product-list')
    @break
    @endswitch
</div>