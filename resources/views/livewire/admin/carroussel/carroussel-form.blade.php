<div>
<form class="carrousselForm " wire:submit.prevent="uploadImg">
    @error('image')
        <span>Insira uma imagem por favor </span>
    @enderror
    @if(session()->has('message'))
    {{session('message')}}
    @endif
    <input type='file' class="hidden" name="image" id="image" wire:model="image" />

    <label for="image" class="preview">
        @if ($image) 
        <img src="{{$image->temporaryUrl()}}" alt="">
        @else
        <i class="fa-solid fa-image"></i>
        @endif
    </label>
    <button type="submit" class="btn-1" >
        <span wire:loading wire:target="uploadImg" wire:key="uploadImg">
        <i class="fa-solid fa-spinner spinning"></i>
        </span>
        Enviar
     </button>    
</form>

</div>