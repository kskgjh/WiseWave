<div class="currentCarroussel">
    @if(!$images->isEmpty())
    <i class="fa-solid fa-trash-can"
    id="deleteBtn"
    wire:click="deleteThis"></i>
    @endif
    <div class="currentImg">
        @if($images->isEmpty())
        <h1>Nenhuma imagem cadastrada</h1>
        @else
        <img src="{{asset("assets/imgs/carroussel/". $images[$currentMain]->imgName)}}"
             alt="" 
             class="mainImg">
        @endif
        </div>


    <div class="allImgs">
        @foreach($images as $image)
            <img wire:click="changeImg({{$loop->index}})"
                 src="{{asset("assets/imgs/carroussel/". $image->imgName)}}" 
                 alt="">
        @endforeach
    </div>
</div>
