
<div class="adressInputs">
    <div class="relative">
        <input 
        type="text" x-mask="99999-999" 
        name="cep" placeholder="CEP" x-model="cep" />
        <i class="fa-solid fa-magnifying-glass inputIcon" @click="getAddressByCEP"></i>
    </div>

    <input 
    placeholder="Bairro / Logradouro" 
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
            class="street"
            placeholder="Rua / Alameda / Avenida" 
            type="text" name="street" x-model="street" />
        <input 
            class="number" name="number"
            type="text" x-mask="999999" 
            placeholder="Número" />
    </div>
</div>
