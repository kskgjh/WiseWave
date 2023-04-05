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

        <a href="#overview"><li class="selected">Resumos</li></a>
        <h2>Editar</h2>
        <a href="#carrossel"><li>Carrossel</li></a>
        <li>Produtos</li>
        <li>Sobre nós</li>
        <li>Contatos</li>
    </ul>
</section>