<div x-data="categorySelector()" >
    <input type="hidden" name="category_id" :value="parent_id">
    <div class="categoryDropMenu" id="parentMainMenu">
        <label @click.self="toggleMenu">
            Selecione a categoria
            <i x-show="menu" class="fa-solid fa-chevron-up"></i>
            <i x-show="!menu" class="fa-solid fa-chevron-down"></i>
        </label>
        <div class="categoryMenu" x-show="menu" x-cloak @click.away="toggleMenu()">
            @foreach ($categories as $category)
                @if(count($category->children) > 0)
                    <div class="categoryDropMenu">
                        <label 
                            @click="select({{$category->id}}, $event.target)"
                            @dblclick.stop="toggleSubMenu({{$category->id}})">
                                {{$category->name}}
                                <i class="fa-solid fa-chevron-down" @click.self.stop="toggleSubMenu({{$category->id}})" ></i>
                        </label>
                        <div class="categoryMenu hidden" x-ref="menu_{{$category->id}}">
                            @foreach ($category->children as $child)
                                <label @click="select({{$child->id}}, $event.target)">{{$child->name}}</label>
                            @endforeach
                        </div>
                    </div>
                @else
                    <label @click="select({{$category->id}}, $event.target)">{{$category->name}}</label>
                @endif
            @endforeach

        </div>
    </div>
<script>
function categorySelector(){
return {
    categories: @js($categories),
    parent_id: null,
    menu: false,
    init(){console.log(this.categories)},
    toggleMenu(){this.menu = !this.menu},
    toggleSubMenu(id){
        let menu = this.$refs[`menu_${id}`]
        if(menu.classList.contains('hidden')){
            return menu.classList.remove('hidden')
        }
        menu.classList.add('hidden')

    },
    select(id, el){
        let dropMenu = document.querySelector('#parentMainMenu')
        let alredySelected = dropMenu.querySelectorAll('.categorySelected')
        if(alredySelected){
            alredySelected.forEach(element => {
                element.classList.remove('categorySelected')
        });
    }

    this.parent_id = id
    el.classList.add('categorySelected')
    },

}
}
</script>
</div>