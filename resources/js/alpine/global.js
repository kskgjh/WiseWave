export function header(){
    return {
        msg: null,
        open: false,
        toggle() { this.open = !this.open }
    }
}
export function registerForm(){
    return{
        neighborhood: null,
        street: null,
        state: null,
        address: null,
        cep: null,
        city: null,
        uf: null,
        states: [],
        cities: [],
        showpassword: false,
        togglePassword(){this.showpassword = !this.showpassword},
        init(){
            this.states = this.getStates()
        },
        async getAddressByCEP(){
            let intCep = this.cep.replace('-', '');

            let url = `https://brasilapi.com.br/api/cep/v1/${intCep}`
            await axios(url).then((result) => {
                this.address = result.data
            }).catch((err) => {
                return alert(err)
            });
            this.uf = this.address.state
            this.state = (this.states.find((el)=>{
                return el.sigla == this.address.state;
            })).nome
            await this.getCities();
            this.city = this.address.city
            this.address.neighborhood? this.neighborhood = this.address.neighborhood : ''
            this.address.street? this.street = this.address.street : ''
        },
        async getStates(){
            let url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados"
            await axios.get(url)
            .then((result) => {
                let arr = result.data
                this.states = arr.sort((a, b)=>{
                    return a.nome > b.nome? 1 : -1
                })
            }).catch((err) => {
                console.log(err)
            });
        },
        async getCities(){
            let url = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${this.uf}/municipios`
            await axios.get(url)
                .then((result) => {
                    let arr = result.data
                    this.cities = arr.sort((a, b)=>{ return a.nome > b.nome? 1 : -1 })

                }).catch((err) => {
                    console.log(err)
                });
        },
        getUf(){
            let state = this.states.find((el)=>{ return el.nome == this.state })
            this.uf = state.sigla
            this.getCities()
        }

}
}
