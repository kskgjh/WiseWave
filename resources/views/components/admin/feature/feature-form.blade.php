<form class="featuresForm" x-ref="form" @submit.prevent="handleSubmit" method="post" x-data="featureForm">
    @csrf
    @if(session()->has('featurePost'))
        <span>{{session('featurePost')}}</span>
    @endif
    <div class="featuresHeader">
    <h2>Adicionar uma característica</h2>
        <select name="type" x-model="type">
            <option selected>Selecionar tipo</option>
            <option value="text">Texto</option>
            <option value="items">Tópicos</option>
        </select>
    </div>

    <template x-if="type == 'text'">
        <div class="text">
            <input type="text" name="title" placeholder="Título">
            <textarea name="text"  rows="15" placeholder="Descrição"></textarea>

        </div>
    </template>

    <template x-if="type == 'items'">
        <div class="itemsFeature">
            <input type="text" name="title" placeholder="Título">
            <div x-ref="items" ></div>
        </div>
    </template>

    <template x-if="type !== null">
        <div class="buttonsDiv">
            <button class="btn-1">Adicionar</button>
            <button type="button" class="btn-2"> Cancelar</button>
        </div>
    </template>

</form>