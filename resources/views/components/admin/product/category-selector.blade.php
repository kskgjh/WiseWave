<div x-data="categorySelector" @category-select.window="handleEvent($event)" id="category_selector_{{$context}}">
    <input type="hidden" name="category_id" :value="category_id">

    <div class="categoryDropMenu relative" id="parentMainMenu">
        <label @click.stop="toggleMenu">
            <h4 x-text="selected"></h4>
            <i class="fa-solid" :class="menu? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </label>

        <div class="categoryMenu border absolute hidden" x-ref="category_menu_{{$context}}" x-cloak @click.away="toggleMenu">

            <template x-if="categories">
            <template x-for="category in categories">

                <template x-if="category.children.length > 0">
                    <div class="categoryDropMenu relative">
                        <label :id="`category_{{$context}}_${category.id}`" @click="toggleSubMenu(category.id)" @dblclick.self="select(category.id, category.name)">
                            <span x-text="category.name"></span>
                            <i  class="fa-solid fa-chevron-right" 
                                :id="`menuIcon_{{$context}}_${category.id}`" 
                                @click.self.stop="toggleSubMenu(category.id, $event.target)"></i>
                        </label>

                        <div class="categorySubMenu absolute hidden" :id="`menu_{{$context}}_${category.id}`">
                            <template x-for="children in category.children">
                                <label :id="`category_{{$context}}_${children.id}`" @click="select(children.id, children.name)">
                                    <span x-text="children.name"></span>
                                </label>
                            </template>
                        </div>

                    </div>
                </template>

                <template x-if="category.children == undefined">
                    <label :id="`category_{{$context}}_${category.id}`" @click="select(category.id, category.name)"><span x-text="category.name"></span></label>
                </template>
            </template>
            </template>
    </div>
        <i class="fa-solid fa-rotate-left categoryReset" @click="resetCategory"></i>
    </div>
</div>

