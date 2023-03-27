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
        @livewire('admin.products.add-product-variants')
    </div>
        @livewire('admin.products.product-list')
    @break
    @endswitch
</div>