<section x-data="sideBar">
    <template x-if="!hidden">
        <i class="fa-solid fa-bars" id="menuBtn" @click="toggleSideBar" ></i> 
    </template>
    <template x-if="hidden">
        <i class="fa-solid fa-xmark" id="menuBtn" @click="toggleSideBar" ></i> 
    </template>

<nav>
    <ul id="sideBarMenu" x-cloak :class="hidden ? '':'sideBarHide' "
        @click="toggleSelected($event.target)" 
        @click.outside="hidden ? toggleSideBar : '' ">
            {{$slot}}
    </ul>
</nav>
</section>