<div x-data="mostSalesProducts" class="mostSales">
    <h2>Mais vendidos</h2>
    <div>
        <template x-if="products.length > 0">
        <template x-for="product in products">

        <a class="btn-link productCard" :href="`/product/render/${product.id}`">

                <template x-if="product.amount == 0">
                    <span class="amount0">Sem estoque :(</span>
                </template>
                <template x-if="detectUrl.test(product.product_imgs[0].path)">
                    <img :src="product.product_imgs[0].path" alt="">
                </template>
                <template x-if="!detectUrl.test(product.product_imgs[0].path)">
                    <img :src="`assets/imgs/product/${product.product_imgs[0].path}`" alt="">
                </template>
                <div class="productInfos">
                    <span x-text="product.name"></span>
                    <div>
                        <label>
                            R$ 
                            <span x-text="product.price"></span>
                        </label>
                        <label>
                            Vendidos: 
                            <span x-text="product.sales"></span>
                        </label>
                    </div>
                </div>

        </a>

        </template>
        </template>    
    </div>
</div>