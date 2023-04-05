<form class="carrousselForm " enctype="multipart/form-data" method="post" action="{{route('banner.save')}}"  x-data="carrousselForm">
    @csrf
    @error('image')
        <span>Insira uma imagem por favor </span>
    @enderror
    @if(session()->has('message'))
    {{session('message')}}
    @endif
    <input type='file' class="hidden" name="image" id="image" @change="getPath($event)" />

    <label for="image" class="preview">

        <template x-if="imagePath">
            <img :src="imagePath">
        </template> 
        <template x-if="!imagePath">
            <i class="fa-solid fa-image"></i>
        </template> 

    </label>
    <div class="bannerDesc">
        <label class="flex-column">
            @error('title')
                {{$message}}
            @enderror
            <input type="text" name="title" placeholder="Nome da imagem">
        </label>
        <label>
            <input type="text" name="alt" placeholder="Descrição da imagem">
        </label>
    </div>
    <button type="submit" class="btn-1" >
        <span wire:loading wire:target="uploadImg" wire:key="uploadImg">
            <i class="fa-solid fa-spinner spinning"></i>
        </span>
        Enviar
     </button>    
</form>

