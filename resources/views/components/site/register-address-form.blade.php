
<div class="adressInputs">
    <div class="relative">
        <input 
        type="text" x-mask="99999-999" dusk="cep"
        name="cep" placeholder="CEP" x-model="cep" />
        <i class="fa-solid fa-magnifying-glass inputIcon" dusk="cep_search" @click="getAddressByCEP"></i>
    </div>

    <input 
    placeholder="Bairro / Logradouro" dusk="neighborhood"
    name="neighborhood" type="text" x-model="neighborhood" />

    <select name="state" x-model="state" @change="getUf">
        <option value="null" disabled selected>Selecione seu estado</option>
        <template x-if="states.length > 0" >
            <template x-for="(state, index) in states">
                <option x-value="state.nome" x-text="state.nome"></option>
            </template>
        </template>
    </select>

    <select name="city" x-model="city">
        <option value="null" disabled selected>Selecione sua cidade</option>
        <template x-if="cities.length > 0">
            <template x-for="(city, index) in cities">
                <option x-value="city.nome" x-text="city.nome"></option>
            </template>
        </template>
    </select>
    <div class="streetDiv">
        <input 
            class="street" dusk="street"
            placeholder="Rua / Alameda / Avenida" 
            type="text" name="street" x-model="street" />
        <input 
            class="number" name="number"
            type="text" x-mask="999999" 
            placeholder="Número" dusk="number" />
    </div>
</div>
