<div>
    <form 
        action="{{route('product.add.category')}}" 
        method="post" 
        class="categoryForm" 
        x-data="categoryForm()">
        @csrf
        @if(session()->has('success'))
            {{session('success')}}
        @endif
        @error('name')
            {{$message}}
        @enderror
        <div>
            <input type="text" name="name" placeholder="Nome da categoria">
            <select name="type" x-model="type" >
                <option value="parent" selected>Categoria principal</option>
                <option value="child">Sub-categoria</option>
            </select>
        </div>
        <template x-if="type == 'child'">
            <select name="parent_id" class="parentCategory">
                <option value="" disabled selected>Selecione a categoria pai</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </template>

        <button class="btn-1">Cadastrar</button>
    </form>
    <script>
    function categoryForm(){
    return {
        type: 'parent',

    }
    }

    </script>
</div>
