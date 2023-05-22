<form @submit.prevent="handleSubmit" action="{{route('feature.add.product')}}" method="post" x-data="productFeature" class="productFeature" x-ref="form">
    @csrf
    @if(session()->has('feature'))
        <span>{{session('feature')}}</span>
    @endif
    <h2>Adicionar característica a um produto</h2>
    <div>
        <label>Selecione o produto
            <select name="product" x-model="product">
                <option value="null" selected disabled>Selecione</option>
                @foreach ($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
            
        </label>

        <label>Selecione a característica
            <select name="feature" x-model="feature">
                <option value="null" selected disabled>Selecione</option>
                <template x-if="features">
                <template x-for="feature in features">
                    <option :value="feature.id" x-text="feature.title"></option>    
                </template>
                </template>
            </select>
        </label>
    </div>
    <div>
        <button class="btn-1 inline">Adicionar</button>
        <button class="btn-2" type="button" @click="reset">Cancelar</button>
    </div>
</form>