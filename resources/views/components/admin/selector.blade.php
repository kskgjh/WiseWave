<div class="main" x-data="adminSelector" @change-page.window="changePage($event)">


        <template x-if="current == 'Carrossel'">
            <div class="carrousselAdminPanel">
                @component('components.admin.carrossel.carrossel-form')@endcomponent
                @component('components.admin.carrossel.current-carrossel')@endcomponent
            </div>
        </template>

        <template x-if="current == 'Produtos'">
        <div>
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
        </template>

        <template x-if="current == 'Características'">
            <div class="features">
                @component('components.admin.feature.feature-form')@endcomponent
                @component('components.admin.feature.put-feature-in-product', ['products'=> $products])@endcomponent
            </div>
        </template>

</div>