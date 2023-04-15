<div>
    <form 
        action="{{route('add.variant', ['amount'=> $variants])}}" 
        method="POST"
        class="productVariantForm" 
        >
        @csrf
        @if(session('sucess'))
            <p style="color: white">Variante criada com sucesso</p>
        @endif
        <div class="variantsHeader">
            @error('title')
            {{$message}}
            @enderror
            <input 
                type="text" 
                placeholder="Título da variação"
                name="title"/>
            <select wire:model="type" name="type">
                <option value="1">Modelos</option>
                <option value="2">Cores</option>
            </select>
        </div>
        
        
        @for($i = 0; $i < $variants; $i++)
        <div class="variantOptions">
            @if($type == 1)
                <input 
                    type="text" 
                    name="variantOption{{$i+1}}" 
                    placeholder="Opção {{$i+1}}" />
            @elseif($type == 2)
                <label class="colorLabel">
                    <input 
                        type="text" 
                        name="colorName{{$i+1}}"
                        placeholder="Cor">
                    <input 
                        type="color"
                        name="variantColor{{$i+1}}" /> 

     
                </label>
            @endif 

            @if($i == $variants - 1)
            <i class="fa-solid fa-trash trash" wire:click="excludeVariant"></i>
            @endif  

        </div>
        @endfor

        <button type="button" class="add-sub-div" wire:click="addVariant">
            <p>Adicionar nova opção</p>
            <i class="fa-solid fa-plus"></i>
        </button>

        <div class="buttonsDiv">
            <button class="btn-1">Enviar</button>
            <button class="btn-2">Cancelar</button>
        </div>
    </form>
</div>
