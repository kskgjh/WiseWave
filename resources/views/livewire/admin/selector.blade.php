<div class="main" x-data="adminSelector" @change-page.window="changePage($event)">
       
    <template x-if="current == 'Carrossel'">
        <div>
            @livewire('admin.carroussel.carroussel-form')
            @livewire('admin.carroussel.current-carroussel')
        </div>
    </template>

    <template x-if="current == 'Produtos'">
        <div>
            <div class="productsForms">
                @livewire('admin.products.product-form')
                <div class="rightSide">
                    @livewire('admin.products.variants-form')
                    @livewire('admin.products.category-form')
                </div>
            </div>
            @livewire('admin.products.product-list')
        </div>
    </template>

</div>