<div x-data="carroussel()" @mouseover="stopInterval()" @mouseleave="startInterval()">
    <section id="carroussel">
        <div class="left" @click="changeImg(-1)">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="main">
            @if(count($imgs) > 0)
            <img :src="`assets/imgs/carroussel/${images[current].imgName}`" /> @endif
        </div>
        <div class="right" @click="changeImg(1)">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </section>
    <script>
        function carroussel(){
        return{
            images: @js($imgs),
            current: @entangle('current'),
            interval: null,
            init(){
                this.startInterval()
            },
            startInterval(){
                this.interval = setInterval(() => {
                    this.changeImg(1)
                }, 3000);
            },
            stopInterval(){
                clearInterval(this.interval)
            },
            changeImg(direction){
                console.log(`carroussel changing in `, direction)
                if(this.current + direction < 0) return this.current = this.images.length - 1 
                if(this.current + direction == this.images.length) return this.current = 0 

                this.current += direction
            }
        }
        }
    </script>
</div>
