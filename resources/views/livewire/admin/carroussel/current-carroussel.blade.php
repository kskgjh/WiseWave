<div class="currentCarroussel" x-data="currentCarroussel">

    <div id="modal" x-show="modal" x-cloak>
        <div id="modalContent">
            <form action="{{route('banner.delete')}}" method="post">
                @csrf
                @method('delete')
                <h2>Tem certeza que deseja excluir a imagem</h2>
                <h3 style="text-align: center" x-text="currentTitle"></h3>
                <input type="hidden" name="id" :value="currentId">
                    <div class="buttonsDiv">
                        <button class='btn-1'>Confirmar</button>
                        <button class='btn-2' @click="toggleModal" type="button">Cancelar</button>
                    </div>
            </form>

            
        </div>
    </div>


    <div class="currentImg" @click="deleteImg" @mouseover="hovering = true" @mouseleave="hovering = false">

        <template x-if="hovering && currentImg">
            <i class="fa-solid fa-trash-can banner-delete"
            wire:click="deleteThis"></i>
        </template>

        <template x-if="images.length == 0">
            <span style="color: white">Nenhuma imagem cadastrada!</span>
        </template>

        <template x-if="images.length > 0">
            <img :src="currentImg"
            alt="" 
            class="mainImg">
        </template>

        </div>

    <div class="allImgs">
        <template x-for="image in images">
            <img 
            :src="`assets/imgs/carroussel/`+ image.path" 
            :alt="image.alt"
            @click.self="changeImg(image.path, image.id)"
            >
        </template>
    </div>
</div>
