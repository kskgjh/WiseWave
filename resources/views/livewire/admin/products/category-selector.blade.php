<div x-data="categorySelector()" >
    <input type="hidden" name="category_id" :value="parent_id">
    <div class="categoryDropMenu" id="parentMainMenu">

        <label @click.stop="toggleMenu" >
            <h3 x-text="selected"></h3>
            
            <template x-if="menu">
                <i class="fa-solid fa-chevron-up"></i>
            </template>
            <template x-if="!menu">
                <i class="fa-solid fa-chevron-down"></i>
            </template>


        </label>
        <div 
            class="categoryMenu" 
            style="position: absolute" 
            x-show="menu" x-cloak 
            @click.away="toggleMenu">

            @foreach ($categories as $category)
                @if(count($category->children) > 0)
                    <div class="categoryDropMenu">
                        <label @dblclick.self="select({{$category->id}}, $event.target, '{{$category->name}}')"
                            @click="toggleSubMenu({{$category->id}})" >
                                {{$category->name}}
                                <i  class="fa-solid fa-chevron-down" 
                                    @click.self.stop="toggleSubMenu({{$category->id}}, $event.target)" ></i>
                        </label>
                        <div class="categoryMenu hidden" x-ref="menu_{{$category->id}}">
                            @foreach ($category->children as $child)
                                <label @click="select({{$child->id}}, $event.target, '{{$child->name}}')">
                                    {{$child->name}}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @else
                    <label @click="select({{$category->id}}, $event.target, '{{$category->name}}')">
                        {{$category->name}}
                    </label>
                @endif
            @endforeach

        </div>
        <i class="fa-solid fa-rotate-left categoryReset" @click="resetCategory"></i>
    </div>
<script>
function categorySelector(){
return {
    categories: @js($categories),
    selected: "Selecione a categoria",
    parent_id: null,
    menu: false,
    toggleMenu(e){
        console.log(e)
        this.menu = !this.menu
        console.log(this.menu)
    },
    toggleSubMenu(id, target = false){
        let menu = this.$refs[`menu_${id}`]

        if(!target){
            target = menu.parentElement.children[0].children[0]
        }
        if(target){
            if(target.classList.contains("fa-chevron-down")){
                target.classList.add("fa-chevron-up")
                target.classList.remove("fa-chevron-down")
            } else {
                target.classList.remove("fa-chevron-up")
                target.classList.add("fa-chevron-down")
            }
        }

        if(menu.classList.contains('hidden')){
            return menu.classList.remove('hidden')
        }
        menu.classList.add('hidden')

    },
    select(id, el, option){
        let dropMenu = document.querySelector('#parentMainMenu')
        let alredySelected = dropMenu.querySelectorAll('.categorySelected')
        if(alredySelected){
            alredySelected.forEach(element => {
                element.classList.remove('categorySelected')
        });
        setTimeout(() => {
            this.menu = false
        }, 300);
    }

    this.parent_id = id
    this.selected = option
    el.classList.add('categorySelected')
    },
    resetCategory(){
        this.parent_id = null
        this.selected = "Selecione a categoria"
    }

}
}
</script>
</div>