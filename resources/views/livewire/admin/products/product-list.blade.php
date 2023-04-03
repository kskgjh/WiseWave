<div x-data="productList" 
     @add-product.window="addProduct($event)" 
     id="productTable"
     @current-page.window="getProducts($event)">
@if(count($products) > 0)
    <div class="tableHeader">
        <label class='checkAll'>
            <input @change="selectAll($event.target)" x-ref="checkAll" x-bind:checked="somethingSelected" type="checkbox">
            Marcar todos
            <span x-text="howManySelected"></span>
        </label>
        <span @click="delSelected" x-show="somethingSelected" x-cloak class="removeAll">Remover Selecionados</span>
    </div>

    <table class="productList" >
        <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Status</th>
            <th>Estoque</th>
            <th>Excluir</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
        <tr @click="isSelected({{$product->id}})">
            <th>
                <input 
                    x-ref="check_{{$product->id}}" 
                    type="checkbox" 
                    @click.stop="select({{$product->id}}, {{$loop->index}})">
                {{$product->id}}
            </th>    
            <th>{{$product->name}}</th>    
            <th>{{$product->status}}</th>    
            <th>{{$product->amount}}</th>    
            <th>
                 <a @click.stop href="{{route('product.delete', ['id'=> $product->id])}}"> 
                    <i class="fa-solid fa-trash"></i>
                </a>
            </th>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{$products->links('vendor.pagination.default')}}
    @endif
        <div x-show="modal" x-cloa>
            <form action="" class="productModal">
                <div class="updateTitle">
                    <i class="closeButton fa-solid fa-arrow-left-long" @click="toggleModal"></i>

                    <h1 x-ref="productName"></h1>
                    
                    <template x-if="currentStatus">
                        <label for="currentStatus">
                            Ativo
                            <i class="fa-regular fa-square-check"></i>    
                        </label>
                    </template>
                    <template x-if="!currentStatus">
                        <label for="currentStatus">
                            Desativado
                            <i class="fa-regular fa-square"></i>    
                        </label>
                    </template>
                    <input 
                        type="checkbox" 
                        class="hidden" 
                        id="currentStatus"
                        x-model="currentStatus">
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
                        <label x-ref="variant_label">Variante:
                            <select name="variant_id" x-model="currentVariant">
                                    <option value="null">Selecionar uma variante</option>
                                @foreach ($variants as $variant)
                                    <option value="variant_{{$variant_id}}">{{$variant->title}}</option>    
                                @endforeach
                            </select>   
                        </label>

                        <label class="desc">Descrição: 
                            <textarea x-ref="text" rows="8" cols="20"></textarea>
                        </label>
                    </div>
                </div>
                        <div class="dimensions" id="dimensions">
                            <button class="btn-1" type="button" @click="addDimensions($event)">
                                Incluir dimensões 
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                    <div class="buttonsDiv">
                        <button class="btn-1">Atualizar</button>
                        <button type="button" class="btn-1" @click="window.location.reload()">Cancelar</button>
                    </div>
            </form>
            </div>
    </div>
</div>
