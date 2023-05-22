import { moneyFormat, sleep } from "../functions"

export function header(){
    return {
        msg: null,
        open: false,
        search: false,
        toggleSearchBar(){ 
            let searchBar = this.$refs.search;
            if(searchBar.classList.contains('hideSearchBar')){
                searchBar.classList.remove('hideSearchBar');
                return searchBar.focus();
            }
            return searchBar.classList.add('hideSearchBar');
        },
        toggle() { this.open = !this.open }
    }
}
export function sideBar() {
    return {
        hidden: false,
        toggleSideBar() { this.hidden = !this.hidden; },
        toggleSelected(target) {
            let listEl = document.querySelector("#sideBarMenu");
            let arr = document.querySelectorAll(".selected");

            if (target == listEl) return;

            arr.forEach((element) => {
                if (element.classList.contains("selected"))
                    element.classList.remove("selected");
            });
            target.classList.add("selected");
            let event = new CustomEvent("change-page", {
                detail: target.innerText,
            });
            dispatchEvent(event);
        },
    };
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
export function carrossel(){
    return{
        images: [],
        current: 0,
        interval: null,
        init(){
            this.getImages();
            this.startInterval();
        },
        async getImages(){
            await axios.get('/banner')
                .then((result) => {
                    console.log('get images result: ', result.data)
                    this.images = result.data;
                }).catch((err) => {
                    alert(err);
                });
        },
        startInterval(){
            this.interval = setInterval(() => {
                this.changeImg(1)
            }, 3500);
        },
        stopInterval(){
            clearInterval(this.interval)
        },
        changeImg(direction){
            if(this.current + direction < 0) return this.current = this.images.length - 1 
            if(this.current + direction == this.images.length) return this.current = 0 

            this.current += direction
        }
    }
}
export function mostSalesProducts(){
    return{
        products: [],
        detectUrl: new RegExp("^https://"),
        init(){ this.getProducts() },
        async getProducts(){
            await axios.get('/product/sales')
                .then((result) => {
                    this.products = result.data.data
                }).catch((err) => {
                    alert(err)
                });
        this.formatPrices();
        },
        formatPrices(){
            this.products.map((product)=>{
                product.price = moneyFormat(product.price);
            });
        },

    };
}
export function productRequest(){
    return{
        currentImg: null,
        productId: null,
        images: null,
        async init(){ 
            this.getProductId();
            this.getProductImgs();
        },
        changeImg(path){
            console.log('changing image')
            let detectUrl = new RegExp("^https://");
            if(detectUrl.test(path)) return this.$refs.image.src = path; 

            this.$refs.image.src = `/assets/imgs/product/${path}`;
        },
        getProductId(){
            let url = new URL(window.location.href).pathname
            let urlArr = url.split('/')
            this.productId = urlArr[3]
        },
        async getProductImgs(){
            let url = `/product/find/${this.productId}`;
            await axios.get(url)
                .then((result) => { 
                    this.images = result.data.product_imgs;
                    this.currentImg = this.images[0].name;
                }).catch((err) => {
                    alert(err)
                });
        },
        changeVariant(id, el){
            let variants = this.$refs.variants;
            let selected = variants.querySelector('.selected');
            selected.classList.remove('selected');

            el.classList.add('selected');
            this.$refs.variantInput.value = id
        },
        handleSubmit(option){

            if(option == 'toCart') {
                this.$refs.form.action = 'http://localhost:8000/cart';
                this.$refs.form.submit();
            }

        }
        
    };
}
export function cart(){
    return{
        itemToDel: null,
        modal: false,
        toggleModal(){ this.modal = !this.modal },
        confirmDelete(id, name){
            this.$refs.deleteName.innerText = name;
            this.itemToDel = id;
            this.toggleModal();
        }
    };
}
export function searchFilters(){
    return {
        search: null,
        orderby: 'default',
        max_value: 0,
        min_value: 0,
        category_id: null,
        selectCategory(event){
            let target = event.target;

            if(target !== this.$refs.categoryList && target !== event.currentTarget){
                let currentSelected = document.querySelector('.categorySelected')
                console.log(currentSelected)
                if(currentSelected) currentSelected.classList.remove('categorySelected')

                this.category_id = target.id
                target.classList.add('categorySelected');
            }
        },
        getSearchBar(event){
            this.search = event.detail.search;

        }
    }
}
export function productSearch(){
    return{
        search: null,
        init(){
            let search = this.$refs.component.dataset.search
            if(search) {
                this.search = search
                this.searching()
            }

        },
        searching(){
            console.log('searching for: ', this.search);
            let products = this.$refs.productList.children;
            let productArr = Array.from(products);
            let search = this.search.toLowerCase();

            productArr.forEach((el)=>{
                let name = el.querySelector('h3').innerText.toLowerCase();
                if(!name.match(search)) {
                    el.classList.add('hidden')
                } else {
                    el.classList.remove('hidden')

                }
                
            })

            this.$dispatch('search-text', {'search': search});
        }
    }
}