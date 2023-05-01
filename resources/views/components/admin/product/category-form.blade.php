<div>
    <form action="{{route('category.add')}}" method="post" class="categoryForm" x-data="categoryForm">
        @csrf
        @if(session()->has('success'))
            <span style="color: white">{{session('success')}}</span>
        @endif
        @error('name')
            <span style="color: white">{{$message}}</span>
        @enderror
        <div>
            <input type="text" name="name" placeholder="Nome da categoria">
            <select name="type" x-model="type" >
                <option value="parent" selected>Categoria principal</option>
                <option value="children">Sub-categoria</option>
            </select>
        </div>

        <select name="parent_id" x-show="type == 'children'" class="parentCategory">
            <option value="null" disabled selected>Selecione a categoria pai</option>
            <template x-if="categories">
                <template x-for="category in categories">
                    <option x-value="category.id" x-text="category.name"></option>
                </template>
            </template>
        </select>
       

        <button class="btn-1">Cadastrar</button>
    </form>
</div>
