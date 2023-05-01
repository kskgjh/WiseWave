<div x-data="productForm" x-init="$watch('images', e=> console.log(e))">
    <form 
        method="POST" 
        class="productForm" 
        action="{{route('product.add')}}"
        enctype="multipart/form-data"
        x-ref="form"
        @submit.prevent="submit">

        @csrf
        <div class="productForm-inputs">
            @if (session('productCreated'))
                <span style="color: white"> {{session('productCreated')}} </span>
            @endif
            @error('name')
            <span style="color: white">{{$message}}</span>
            @enderror
            <input 
                type="text" 
                name="name" 
                placeholder="Nome do produto"/>
            @error('value')
            <span style="color: white">{{$message}}</span>
            @enderror

            <input 
                type="text" class="money"
                placeholder="Preço (R$)" 
                name="value"
                x-model="value" x-mask:dynamic="$money($input, ',')"/>
            <textarea 
                name="text" cols="15" 
                rows="6" placeholder="Descrição do item"></textarea>

            <div class="notTextDiv">

                <label>Quantidade em estoque:  
                    <input 
                        type="number" value="0"
                        name="amount" />
                </label>

                <label>Ativo
                    <i class="fa-regular" :class="status? 'fa-square-check' : 'fa-square'"></i>
                    <input 
                        id="checkbox"
                        type="checkbox"
                        name="status"
                        x-model="status"
                        class="hidden"
                        checked>
                </label>
                
                <div>
                <select name="variant" x-model="select">
                    <option value="null" disabled selected>
                        Selecionar uma variação
                    </option>
                    <template x-if="variants.length > 0">
                        <template x-for="variant in variants">
                            <option x-value="variant.id" x-text="variant.title"></option>
                        </template>
                    </template>
                </select>
                <i class="fa-solid fa-rotate-left variantReset" @click="resetSelect()"></i>
                </div>

                @component('components.admin.product.category-selector', ['context'=> 'product_form'])@endcomponent
            </div>

            <div class="buttonsDiv" >
                <button type="submit" class="btn-1">Enviar</button>
                <button type="button" class="btn-2">Cancelar</button>
            </div>
        </div>


        <div class="productImages">

            @error('images')    
            <span style="color: white">{{$message}}</span>
            @enderror

            <template x-for="i in imgInputCount">
                <label class="imgsLabel" :id="`label_${i}`">
                    <img :id="`image_${i}`" class="zindex10 hidden" alt="">
                    <i class="fa-solid fa-image" :id="`icon_${i}`"></i>
                    <input    
                        name="images[]"
                        type="file" 
                        class="hidden" 
                        :id="`input_${i}`"
                        @change="storeFile($event.target)">
                    </label>
            </template>

        </div>

        <div id="modal" x-show="modal">
            <div id="modalContent">
                <h2>Tem certeza que deseja excluir essa imagem?</h2>
                <div class="buttonsDiv">
                    <button class="btn-1" type="button" @click="delImage">Confirmar</button>
                    <button class="btn-2" type="button" @click="cancelDelete">Cancelar</button>
                </div>
            </div>
        </div>

    </form>
</div>