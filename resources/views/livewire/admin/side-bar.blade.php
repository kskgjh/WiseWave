<section>
<i  @if($hidden)
    class="fa-solid fa-bars"
    @else
    class="fa-solid fa-xmark"
    @endif

    id="menuBtn"
    wire:click="switchSideBar" ></i> 

    <ul id="sideBarMenu"    
        @if($hidden)
        class="hideSideBar"
        @endif>
        <li>Resumos</li>
        <h2>Editar</h2>
        <li wire:click="sendEmit('carroussel')"
            @if($selected == 'carroussel')
            class="selected"
            @endif >
            Carrossel
        </li>
        <li wire:click="sendEmit('products')"
            @if($selected == 'products')
            class="selected"
            @endif>
            Produtos
        </li>
        <li>Sobre nós</li>
        <li>Contatos</li>
    </ul>
</section>