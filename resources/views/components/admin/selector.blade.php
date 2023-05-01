<div class="main" x-data="adminSelector" @change-page.window="changePage($event)">



        <div class="carrousselAdminPanel" x-show="current == 'Carrossel'" x-cloak>
            @component('components.admin.carrossel.carrossel-form')@endcomponent
            @component('components.admin.carrossel.current-carrossel')@endcomponent
        </div>

        <div x-show="current == 'Produtos'" x-cloak>
            <div class="productsForms" >
                @component('components.admin.product.product-form')@endcomponent
                <div class="rightSide">
                @component('components.admin.product.variant-form')@endcomponent
                @component('components.admin.product.category-form')@endcomponent
                </div>
            </div>
            @if(session()->has('productUpdated'))
                <div class="message">
                    <span>{{session('productUpdated')}}</span>
                </div>
            @endif
            @component('components.admin.product.product-list', ['products'=> $products])@endcomponent
        </div>


</div>