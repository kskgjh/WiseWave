
    <form 
        x-data="variantForm"
        method="POST"
        class="productVariantForm"
        @submit.prevent="submit">

        @csrf
        @if(session('sucess'))
            <p style="color: white">Variante criada com sucesso</p>
        @endif
        @error('title')
        <span style="color: white">{{$message}}</span>
        @enderror
        <div class="variantsHeader">

            <input 
                type="text" 
                placeholder="Título da variação"
                name="title"/>
            <select x-model.number="type" name="type">
                <option value="1">Modelos</option>
                <option value="2">Cores</option>
            </select>
        </div>
        <div id="variantOptionList">
            
   

        </div>

        <template x-if="type == 1">
            <button type="button" class="add-sub-div" @click="addTextOption">
                <p>Adicionar nova opção</p>
                <i class="fa-solid fa-plus"></i>
            </button>
        </template>
        
        <template x-if="type == 2">
            <button type="button" class="add-sub-div" @click="addColorOption">
                <p>Adicionar nova cor</p>
                <i class="fa-solid fa-plus"></i>
            </button>
        </template>

        <div class="buttonsDiv">
            <button class="btn-1">Enviar</button>
            <button class="btn-2">Cancelar</button>
        </div>
    </form>
