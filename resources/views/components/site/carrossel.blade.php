
<div x-data="carrossel()" @mouseover="stopInterval()" @mouseleave="startInterval()">
<template x-if="images.length > 0">
    <section id="carroussel">
        <div class="left" @click="changeImg(-1)">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="main">
            <img :src="`http://localhost:8000/assets/imgs/carroussel/${images[current].path}`" /> 
        </div>
        <div class="right" @click="changeImg(1)">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </section>
</template>
</div>
