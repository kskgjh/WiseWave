<div @render-page.window="productPage" x-data="productPage">
    <form action="{{route('product.update')}}" x-ref="form" method="post" class="productModal" @submit.prevent="handleSubmit">
        @csrf
        @method('put')
        <input type="hidden" name="id" x-model="productId" />
        <input type="hidden" name="volAmount" x-model="volumes">
        @if(session()->has('productUpdated')) 
            <span>{{session('productUpdated')}}</span>
        @endif
        @if(session()->has('volumes')) 
            <span>{{session('volumes')}}</span> 
        @endif 

        <div class="updateTitle">
            <i class="closeButton fa-solid fa-arrow-left-long" @click="toggleModal"></i>
            <input type="text" x-ref="productName" placeholder="Nome do Produto" name="name" />

        </div>

        <div class="productModalMain">
            <div class="productModalImages">
                <img class="productCurrentImg" x-ref="currentImg" :src="currentImg">
                <div x-ref="images"></div>
            </div>
            <div class="productInfos">

                <label>Em estouque:
                    <input type="number" x-ref="amount" name="amount" />
                </label>
                <label>
                    Status: 
                    <div>
                    <i class="fa-regular" :class="currentStatus ? 'fa-square-check' : 'fa-square'"></i>
                    <span x-text="currentStatus? 'Ativado' : 'Desativado'"></span>
                    <input type="checkbox" name="status" class="hidden" id="currentStatus" x-model="currentStatus">
                    </div>
                </label>

                <label x-ref="variant_label">Variante:
                    <select name="variant_id">
                        <option value="null" disabled>Selecionar uma variante</option>
                        <template x-if="variants">
                            <template x-for="variant in variants">
                                <option :value="variant.id" x-text="variant.title"></option>
                            </template>
                        </template>
                    </select>
                </label>

                <label>
                    Categoria: 
                    @component('components.admin.product.category-selector', 
                    ['context' => 'product_page'])
                    @endcomponent
                </label>
                <label class="desc">Descrição:
                    <textarea x-ref="text" name="text" rows="8" cols="20"></textarea>
                </label>

                <label>
                    Vendidos: 
                    <span x-ref="sales"></span>
                </label>

                <label>
                    Preço:
                    <input type="text" x-model="price" x-ref="price" name="price" placeholder="Preço">
                </label>
            </div>
        </div>


        <div class="dimensions" x-ref="dimensions" id="dimensions">
            @if(session()->has('volumeDeleteError'))
                <span>{{session('volumeDeleteError')}}</span>
            @endif
            
            <div x-ref="dimTable"></div>
                <button class="btn-1 inline" type="button" @click="addDimensions($event)">
                    Incluir dimensões
                    <i class="fa-solid fa-plus"></i>
                </button>
                

        </div>
        <div class="buttonsDiv">
            <button class="btn-1">Atualizar</button>
            <button type="button" class="btn-2" @click="$dispatch('close-modal')">Cancelar</button>
        </div>
    </form>
    <div id="modal" x-show="volDelForm" x-cloak>
        <div id="modalContent" >
            <form x-ref="volDelForm" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name='product' x-model="productId">
                <h2>Tem certeza que deseja excluir o volume?</h2>
                <div class="buttonsDiv">
                    <button class="btn-1">Confirmar</button>
                    <button type="button" class="btn-2" @click="volDelModalToggle">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
