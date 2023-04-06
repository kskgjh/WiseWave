<div x-data="categorySelector" >
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
</div>