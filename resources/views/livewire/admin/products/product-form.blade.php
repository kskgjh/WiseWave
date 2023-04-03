<div x-data="{ select: 'null', resetSelect(){this.select = 'null'} }">
<form 
    method="POST" 
    class="productForm" 
    enctype="multipart/form-data"
    wire:submit.prevent="submit"
    >
    @csrf

    <div class="productForm-inputs">
        @if (session('productCreated'))
            <h3> {{session('productCreated')}} </h3>
        @endif
        @error('name')
            {{$message}}
        @enderror
        <input 
            type="text" 
            name="productName" 
            placeholder="Nome do produto"
            wire:model.lazy="name"/>

        @error('value')
            {{$message}}
        @enderror
        <input 
            type="text"
            class="money"
            placeholder="Preço (R$)" 
            name="productValue"
            wire:model="value"/>

        <textarea 
            wire:model="text" 
            cols="15" 
            rows="6" 
            placeholder="Descrição do item"></textarea>
        <div class="amountDiv">
            <label>Quantidade em estoque:  
                <input 
                    type="number" 
                    value="0"
                    name="amount"
                    wire:model="amount" />
            </label>
            <label>Ativo
                @if($status)
                <i class="fa-regular fa-square-check"></i>
                @else
                <i class="fa-regular fa-square"></i>
                @endif
                <input 
                    id="checkbox"
                    type="checkbox"
                    name="status"
                    wire:model="status"
                    class="hidden"
                    checked>
            </label>
        </div>

        <div class="selectDiv">
            <div>
            <select wire:model="variant" x-model="select">
                <option value="null" disabled selected>Selecionar uma variação</option>
                @foreach ($variants as $variant)
                    <option value="{{$variant->id}}">{{$variant->title}}</option>
                @endforeach
            </select>
            <i class="fa-solid fa-rotate-left" x-on:click="resetSelect()"></i>
            </div>
            @livewire('admin.products.category-selector')
        </div>

        <div class="buttonsDiv">
            <button type="submit" class="btn-1">Enviar</button>
            <button type="button" class="btn-1" wire:click="standart">Cancelar</button>
        </div>
    </div>


    <div class="productImages">

        @error('images')    
        <h2>{{$message}}</h2>
        @enderror

        @for ($a = 0; $a<$inputCount; $a++)
        <label class="imgsLabel">
            @isset($images[$a]) 
                <span 
                    class="imgTopIndex" 
                    wire:click="modal('deleteImg', {{$a}})" >
                    <img src="{{$images[$a]->temporaryUrl()}}" alt="">
            </span>
            @endisset

            @if(!isset($images[$a]))
                <i class="fa-solid fa-image"></i>
            @endif
            <input 
                @isset($images[$a])
                    disabled
                @endisset
                name="files[]"
                type="file" 
                class="hidden" 
                wire:model="images" >
        </label>
            
        @endfor


    </div>

</form>
<div id="modal" @if(!$modal) class="hidden" @endif>
    <div class="" id="modalContent">
        @if(!empty($message))
        <h2>{{$message}}</h2>
        @endif
        <div>
            <button class="btn-1" wire:click="closeModal">Cancelar</button>
            <button class="btn-1" wire:click="deleteImg({{$imgIndex}})">Confirmar</button>
        </div>
    </div>
</div>
</div>