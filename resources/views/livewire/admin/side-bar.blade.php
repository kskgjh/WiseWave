<section x-data="adminSideBar">
    <template x-if="!hidden">
        <i class="fa-solid fa-bars" id="menuBtn" @click="toggleSideBar" ></i> 
    </template>
    <template x-if="hidden">
        <i class="fa-solid fa-xmark" id="menuBtn" @click="toggleSideBar" ></i> 
    </template>


    <ul id="sideBarMenu" 
        x-cloak
        :class="hidden ? '':'sideBarHide' "
        @click="toggleSelected($event.target)" 
        @click.outside="hidden ? toggleSideBar : '' ">

        <li id="overview"><a href="#overview">Resumos</a></li>
        <h2>Editar</h2>
        <li id="carrossel"><a href="#carrossel">Carrossel</a></li>
        <li id="products"><a href="#products">Produtos</a></li>
        <li><a href="">Sobre nós</a></li>
        <li><a href="">Contatos</a></li>
    </ul>
</section>