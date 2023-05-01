<form class="carrousselForm " enctype="multipart/form-data" method="post" action="{{route('banner.save')}}"  x-data="carrousselForm">
    @csrf
    @error('image')
        <span style="color:white">Insira uma imagem por favor </span>
    @enderror
    @if(session()->has('message'))
    <span style="color: white">{{session('message')}}</span>
    @endif
    <input type='file' x-ref="input" class="hidden" name="image" id="image" @change="getPath($event)" />

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
                <span style="color: white">{{$message}}</span>
            @enderror
            <input 
                type="text" 
                name="title" 
                placeholder="Nome da imagem"
                @error('title') class="invalidField" @enderror>
        </label>
        <label>
            <input 
                type="text" 
                name="alt" 
                placeholder="Descrição da imagem"
                @error('title') class="invalidField" @enderror>

        </label>
    </div>
    <div class="buttonsDiv">
        <button type="submit" class="btn-1" >Enviar</button>    
        <button type="button" class="btn-2" @click="resetForm">Cancelar</button>
    </div>
</form>

