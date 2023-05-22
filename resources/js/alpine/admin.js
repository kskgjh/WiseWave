import { moneyFormat, sleep } from "../functions";

export function adminSelector() {
    return {
        current: "Resumos",
        changePage(event) { this.current = event.detail; },
        init() {
            let url = window.location.href;
            let params = new URLSearchParams(new URL(url).search);
            this.detectUrl(url, params)
            
        },
        detectUrl(url, params){
            if (url.match("carrossel")) {
                this.current = "Carrossel";
                document.getElementById("carrossel").classList.add("selected");
                return;
            }
            if (url.match("overview")) {
                this.current = "Resumos";
                document.getElementById("overview").classList.add("selected");
                return;
            }
            if (url.match("products") || params.get('page')) {
                this.current = "Produtos";
                document.getElementById("products").classList.add("selected");
                return;
            }
            if (url.match("features")) {
                this.current = "Características";
                document.getElementById("features").classList.add("selected");
                return;
            }
        },
    };
}
export function productPage(){
    return {
        volumes: 0,
        currentImg: null,
        currentStatus: null,
        variant_id: null,
        price: null,
        currentVariant: null,
        productId: null,
        variants: null,
        volDelForm: false,
        volIdToDel: null,
        init(){ this.getVariants()},
        async getVariants(){
            await axios.get('/variant')
            .then((result) => {
                this.variants = result.data;    

            }).catch((err) => {
               alert(err) 
            });
        },
        volDelModalToggle(){ this.volDelForm = !this.volDelForm},
        productPage(e) {
            console.log("rendering-page...")

            let product = e.detail.product
            let detectUrl = new RegExp("^https://");
            let productImages = product.product_imgs;
            let imageDiv = this.$refs.images;

            if (detectUrl.test(productImages[0].name)) {
                this.currentImg = productImages[0].name;
            } else {
                this.currentImg = `assets/imgs/product/${productImages[0].name}`;
            }

            this.$refs.productName.value = product.name;
            this.$refs.amount.value = product.amount;
            this.$refs.text.value = product.text;
            this.$refs.sales.innerText = product.sales;
            this.price = moneyFormat(product.price);
            this.productId = product.id;

            if (product.status == true) {
                this.currentStatus = true;
            }

            if (product.variant_id) {
                this.getCurrentVariant(product.variant_id);
            } else {
                this.currentVariant = "null";
            }

            this.$refs.images.innerHTML = "";
            productImages.forEach((element) => {
                let image = document.createElement("img");
                if (detectUrl.test(element.name)) {
                    image.src = element.name;
                } else {
                    image.src = `assets/imgs/product/${element.name}`;
                }

                imageDiv.appendChild(image);
            });
            this.$dispatch('category-select', {'category_id': product.category_id,
                                                'context': 'product_page'});

            if(product.volumes.length > 0){
                this.renderDimensions(product.volumes)
            }
            this.toggleModal();
        },
        renderDimensions(volumes){
            let div = this.$refs.dimTable;
            div.innerHTML = ""
            
            let thead = document.createElement('thead')
            thead.innerHTML = `
            <tr>
                <th>UN</th>
                <th>Largura</th>
                <th>Comprimento</th>
                <th>Altura</th>
                <th>Peso (Kg)</th>
                <th>Excluir</th>
            </tr>
            `;
            
            let trashCan = document.createElement('i')
            trashCan.classList.add('fa-solid')
            trashCan.classList.add('fa-trash')
            
            let tbody = document.createElement('tbody')

            volumes.forEach((el)=>{
                let tr = document.createElement('tr')
                let amount = document.createElement('th')
                amount.innerText = el.amount

                let width = document.createElement('th')
                width.innerText = el.width

                let height = document.createElement('th')
                height.innerText = el.height

                let length = document.createElement('th')
                length.innerText = el.length

                let weight = document.createElement('th')
                weight.innerText = el.weight

                let trash = trashCan
                trash.addEventListener('click', e=> {
                    this.volIdToDel = el.id
                    this.$refs.volDelForm.action = `/product/vol/del/${el.id}`;

                    this.volDelModalToggle();
                })

                let delTh = document.createElement('th')
                delTh.appendChild(trash)

                tr.appendChild(amount)
                tr.appendChild(width)
                tr.appendChild(length)
                tr.appendChild(height)
                tr.appendChild(weight)
                tr.appendChild(delTh)
                tbody.appendChild(tr)

            })

            let table = document.createElement('table')
            table.classList.add('dimTable')
            table.appendChild(thead);
            table.appendChild(tbody);

            div.appendChild(table)

        },
        async getCurrentVariant(id){
            console.log(`finding title of ${id} variant`)

            if(!this.variants) await sleep(500);

            console.log('product page variants: ', this.variants)

            let variant = this.variants.find((el)=> {
                return el.id == id? el: false;
            })

            this.currentVariant = variant.title
        },
        removeVol(vol){
            vol.remove()
            let volumes = document.querySelectorAll('.volume')
            let arr = Array.from(volumes)
            arr.forEach((el, index)=>{
                let span = el.querySelector('span')
                span.innerText = `Volume ${index + 1} (em cm): `

                let inputs = el.querySelectorAll('input')
                let inputArr = Array.from(inputs)
                inputArr.forEach((el)=>{
                    let id = el.id
                    let currentNumber = id.slice(-2)
                    let type = id.replace(currentNumber, '')

                    el.name = `${type}_${index}`
                    el.id = `${type}_${index}`

                })
            })
            this.volumes = arr.length
            
        },
        addDimensions(e) {
            let el = e.target;
            let elParent = el.parentElement;

            if (el.classList.contains("fa-plus")) {
                el.remove();
                let trashCan = document.createElement("i");
                trashCan.classList.add("fa-solid");
                trashCan.classList.add("fa-trash");
                elParent.appendChild(trashCan);
                trashCan.addEventListener("click", (e) =>
                    this.removeVol(e.target.parentElement)
                );
            } else {
                el.remove();
            }

            let div = document.querySelector("#dimensions");
            console.log(div);

            let span = document.createElement("span");
            span.innerText = `Volume ${this.volumes + 1} (em cm): `;

            let amount = document.createElement('input')
            amount.type = 'number'
            amount.name = `amount_${this.volumes}`
            amount.id = `amount_${this.volumes}`

            let height = document.createElement("input");
            height.type = "number";
            height.name = `height_${this.volumes}`;
            height.id = `height_${this.volumes}`;


            let width = document.createElement("input");
            width.type = "number";
            width.name = `width_${this.volumes}`;
            width.id = `width_${this.volumes}`;


            let length = document.createElement("input");
            length.type = "number";
            length.name = `length_${this.volumes}`;
            length.id = `length_${this.volumes}`;

            let weight = document.createElement('input')
            weight.type = 'text';
            weight.name = `weight_${this.volumes}`;
            weight.id = `weight_${this.volumes}`;

            let labelAmount = document.createElement('label')
            let labelHeight = document.createElement("label");
            let labelWidth = document.createElement("label");
            let labelLength = document.createElement("label");
            let labelWeight = document.createElement('label')

            labelAmount.innerText = "Quantidade: "
            labelAmount.appendChild(amount);

            labelHeight.innerText = "Altura: ";
            labelHeight.appendChild(height);

            labelWidth.innerText = "Largura: ";
            labelWidth.appendChild(width);

            labelLength.innerText = "Comprimento: ";
            labelLength.appendChild(length);

            labelWeight.innerText = "Peso: ";
            labelWeight.appendChild(weight);

            let addVolume = document.createElement("i");
            addVolume.classList.add("fa-solid");
            addVolume.classList.add("fa-plus");

            let volume = document.createElement("div");
            volume.appendChild(span);
            volume.appendChild(labelAmount);
            volume.appendChild(labelHeight);
            volume.appendChild(labelWidth);
            volume.appendChild(labelLength);
            volume.appendChild(labelWeight);
            volume.appendChild(addVolume);
            volume.classList.add("volume");

            div.appendChild(volume);

            this.volumes++;

            addVolume.addEventListener("click", (e) => this.addDimensions(e));
        },
        handleSubmit(){
            let money = moneyFormat(this.price)
            this.price = money

            setTimeout(() => {
                this.$refs.form.submit()
            }, 300);
        }

    }
}
export function productList() {
    return {
        modal: false,
        products: null,
        somethingSelected: false,
        howManySelected: null,
        selected: [],
        page: null,
        toggleModal(){ 
            
            this.modal = !this.modal 
            this.scrollLock()
        },
        async init() {
            document.addEventListener("keyup", (e) => {
                if (e.key == "Escape" && this.modal) this.toggleModal();
            });


            let params = new URLSearchParams(window.location.search);

            this.page = params.get("page")? params.get("page"): 1;
            await this.getProducts();

            if(params.get('product')){
                let index = this.getIndexById(params.get('product'));
                let product = this.products[index];
                console.log(product)
                
                this.$dispatch('render-page', {'product': product});
            } 
        },
        async getProducts() {
            await axios
                .get(`http://localhost:8000/product/?page=${this.page}`)
                .then((result) => {
                    this.products = result.data.data;
                })
                .catch((err) => {
                    alert(err);
                });
        },
        handleDelForm(id){
            let form = document.querySelector(`#delForm_${id}`)
            console.log(form)
            form.submit()
        },
        
        scrollLock() {
            let body = document.querySelector("body");
            if (body.classList.contains("scrollLock")) {
                return body.classList.remove("scrollLock");
            }
            body.classList.add("scrollLock");
        },
        addProduct(e) {
            console.log(e);
            let product = e.detail.product;
            let images = e.detail.images;
            product.images = images;
            this.products.push(product);
        },
        select(id) {
            console.log(`select id: ${id}`);
            const checkbox = this.$refs[`check_${id}`];
            if (checkbox.checked == false) {
                let index = this.selected.indexOf(id);
                this.selected.splice(index, 1);
            } else {
                this.selected.push(id);
                checkbox.checked = true;
            }
            this.selected.length <= 0
                ? (this.somethingSelected = false)
                : (this.somethingSelected = true);
            this.howManySelected = this.selected.length;
        },
        async isSelected(id) {
            if(!this.products) await sleep(500);

            const checkbox = this.$refs[`check_${id}`];

            if (checkbox.checked) {

                let index = this.getIndexById(id)
                let product = this.products[index]
                return this.$dispatch('render-page', {"product": product})
            }
            checkbox.checked = true;
            this.select(id);
        },
        selectAll(el) {
            if (el.checked) {
                this.somethingSelected = true;
                for (let i = 0; i < this.products.length; i++) {
                    let id = this.products[i].id;
                    let checkboxName = `check_${id}`;
                    let checkbox = this.$refs[checkboxName];
                    if (!checkbox.checked) {
                        checkbox.checked = true;
                        this.selected.push(id);
                    }
                }
                this.howManySelected = this.selected.length;

                return;
            }
            this.somethingSelected = false;
            this.selected = [];
            for (let x = 0; x < this.products.length; x++) {
                let id = this.products[x].id;
                let checkboxName = `check_${id}`;
                let checkbox = this.$refs[checkboxName];
                if (checkbox.checked) {
                    checkbox.checked = false;
                }
            }
            this.howManySelected = this.selected.length;
        },
        getIndexById(id){

            console.log('get by id:')
            console.log(id)
            let index = this.products.findIndex((el, index, arr) => {
                if (el.id == id) return true;
            });
            return index
        },
        delSelected() {
            this.selected.forEach((id) => {
                let index = this.getIndexById(id)
                console.log("deleting index ", index, "id: ", id);
                this.products.splice(index, 1);

                axios.delete(`http://localhost:8000/product/del/${id}`)
                        .then((result) => {
                            console.log(result)
                        }).catch((err) => {
                            if(err.response.status !== 405) alert(err)
                        });

            });

            location.reload()
            
        },

    };
}
export function carrousselForm() {
    return {
        imagePath: null,
        getPath(e) {
            if (e.target.files.length == 0) return;
            let file = e.target.files[0];

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (ev) => {
                this.imagePath = ev.target.result;
            };
        },
        resetForm(){
            this.imagePath = null
            this.$refs.input.value = ""
            console.log()
        }
    };
}
export function currentCarroussel() {
    return {
        currentTitle: null,
        currentAlt: null,
        deleteAction: null,
        currentImg: null,
        currentId: null,
        modal: false,
        hovering: false,
        images: [],
        init() {
            console.log("current carroussel init");
            this.getImgs();
        },
        toggleModal() {
            this.modal = !this.modal;
        },
        async getImgs() {
            await axios
                .get("http://localhost:8000/banner")
                .then((result) => {
                    if (!result.data[0]) return;
                    this.images = result.data;
                    this.currentImg = `assets/imgs/carroussel/${result.data[0].path}`;
                    this.currentId = this.images[0].id;
                    this.currentTitle = this.images[0].title;
                    this.currentAlt = this.images[0].alt;
                    this.deleteAction = `/banner/del/${this.images[0].id}`

                })
                .catch((err) => {
                    console.log(err);
                    alert(
                        "Ocorreu um problema ao buscar os banners, por favor recarregue a peagina"
                    );
                });
        },
        changeImg(path, id, title) {
            this.currentTitle = title;
            this.currentId = id;
            this.deleteAction = `/banner/del/${id}`
            this.currentImg = `assets/imgs/carroussel/${path}`;
        },
        deleteImg() {
            this.toggleModal();
        },
    };
}
export function categorySelector() {
    return {
        selected: "Selecione a categoria",
        context: null,
        categories: null,
        showing: null,
        category_id: null,
        menu: null,
        init(){ 
            this.getCategories();
            this.getContext();
            this.menu = `#category_menu_${this.context}`;
        },
        getContext(){
            let elId = this.$el.id
            this.context = elId.replace('category_selector_', '');
        },
        toggleMenu(){ 
            let menu = this.$refs[`category_menu_${this.context}`]
            if(!menu.classList.contains('hidden')){
                if(this.showing){
                    let subMenu = document.querySelector(`#menu_${this.context}_${this.showing}`);
                    this.toggleIcon(this.showing)
                    subMenu.classList.add("hidden");
                }
                return menu.classList.add('hidden')
            }

            menu.classList.remove('hidden')
        },
        async getCategories(){
            console.log('getting categories')
            await axios.get('/category')
                .then((result) => {
                    this.categories = result.data
                }).catch((err) => {
                    alert(err)
                });
        },
        toggleIcon(id){
            console.log('toggle icon of ', id)
            let icon = document.querySelector(`#menuIcon_${this.context}_${id}`)

            if (icon) {
                if (icon.classList.contains("fa-chevron-right")) {
                    icon.classList.add("fa-chevron-left");
                    icon.classList.remove("fa-chevron-right");
                } else {
                    icon.classList.remove("fa-chevron-left");
                    icon.classList.add("fa-chevron-right");
                }
            }
        },
        toggleSubMenu(id) {
            console.log('toggling menu from id: ', id)

            if(this.showing && this.showing !== id){
                this.toggleIcon(this.showing)
                let subMenu = document.getElementById(`menu_${this.context}_${this.showing}`)
                subMenu.classList.add('hidden')
                this.showing = null
            }

            let menu = document.querySelector(`#menu_${this.context}_${id}`)
            this.toggleIcon(id)


            if (menu.classList.contains("hidden")) {
                this.showing = id
                return menu.classList.remove("hidden");
            }
            menu.classList.add("hidden");
            this.showing = null
        },
       async handleEvent(e){
            let id = e.detail.category_id;
            let context = e.detail.context

            if(this.context !== context) return;
            if(!this.categories) await sleep(1000);

            console.log(`selecting category ${id} in ${context}`)

            let el = document.querySelector(`#category_${context}_${id}`);
            let option = el.querySelector('span').innerText

            this.select(id, option, true)

        },
        select(id, option, event = false) {
            let alredySelected = document.querySelector(".categorySelected");
            if(alredySelected){
                alredySelected.classList.remove('categorySelected')
            }

            this.category_id = id;
            this.selected = option;

            let label = document.querySelector(`#category_${this.context}_${id}`)
            label.classList.add("categorySelected");

            if(event) return;

            setTimeout(() => {
                this.toggleMenu();
            }, 300);
        },
        resetCategory() {
            this.parent_id = null;
            this.selected = "Selecione a categoria";
            let selected = document.querySelector('.categorySelected')
            selected.classList.remove('categorySelected')
        },
    };
}
export function productForm(){
    return { 
        select: 'null', 
        status: true,
        value: null,
        tryingToDel: null,
        modal: false,
        imgInputCount: 1,
        images: [],
        variants: [],
        async getVariants(){
            await axios.get("http://localhost:8000/variant")
            .then((result) => {
                this.variants = result.data    
            }).catch((err) => {
                alert(err);
            });
        },
        toggleModal(){this.modal = !this.modal},
        resetSelect(){this.select = 'null'},
        init(){ this.getVariants() },
        storeFile(e){
            let file = e.files[0];
            this.images.push(file)
            this.readFile(file)
        },
        readFile(file){
            let arrLength = this.images.length
            let icon = document.querySelector(`#icon_${arrLength}`)
            let img = document.querySelector(`#image_${arrLength}`)
            let input = document.querySelector(`#input_${arrLength}`);
            console.log(input)
            
            const reader = new FileReader;
            reader.readAsDataURL(file)
            reader.onload = e=> img.src = e.target.result;
            
            input.disabled = true

            icon.classList.add("hidden")
            img.classList.remove("hidden")
            this.imgInputCount++

            img.addEventListener("click", (e)=> {
                e.stopImmediatePropagation();
                this.removeConfirm(arrLength)

            });
        },
        removeConfirm(index){
            this.toggleModal()
            this.tryingToDel = index
        },
        cancelDelete(){
            this.tryingToDel = null,
            this.toggleModal()
        },
        delImage(){
            let index = this.tryingToDel - 1;
            let label = document.querySelector(`#label_${this.tryingToDel}`)
            label.remove();
            this.images.splice(index, 1);
            this.toggleModal()
        },
        async submit(){
            let arrLength = this.images.length
            for(let x = 1; x <= arrLength; x++){
                let input = document.querySelector(`#input_${x}`)
                input.disabled = false                
            }

            let money = moneyFormat(this.value)
            this.value = money;

            await sleep(200);
            this.$refs.form.submit()
        }
        
    }
}
export function variantForm(){
    return {
        variantAmount: 1,
        type: 1,
        optionsDiv: document.querySelector('#variantOptionList'),
        init(){
            this.textOptionsInit();
            this.$watch('type', (value)=>{ value == 1? this.textOptionsInit() : this.colorOptionsInit() });
        },
        submit(){
            let form = document.querySelector('.productVariantForm');
            form.action = `/variant/${this.variantAmount}`;
            form.submit();
        },
        colorOptionsInit(){
            this.variantAmount = 1;
            let option = document.createElement('div')
            option.innerHTML = `
            <label class="colorLabel">
                <input 
                    type="text" 
                    name="colorName_1"
                    placeholder="Cor 1">
                <input 
                    type="color"
                    name="variantColor_1" /> 
            </label>     `
            this.optionsDiv.innerHTML = "";
            this.optionsDiv.appendChild(option)
        },
        textOptionsInit(){
            this.variantAmount = 1;
            let option = document.createElement('div')
            option.innerHTML = `
            <input 
                type="text" 
                name="variantOption_1" 
                placeholder="Opção 1" />`;
            this.optionsDiv.innerHTML = "";
            this.optionsDiv.appendChild(option);
        },
        addTextOption(){ 
            this.variantAmount++;
            let newOption = document.createElement('div');
            newOption.classList.add('variantOptions')
            newOption.innerHTML = `<input 
                                        type="text" 
                                        name="variantOption_${this.variantAmount}" 
                                        placeholder="Opção ${this.variantAmount}" />
                                    <i class="fa-solid fa-trash trash" @click="deleteOption($event.target)"></i>`;
            console.log(newOption);
            this.optionsDiv.append(newOption)
        },
        addColorOption(){
            this.variantAmount++;
            let newOption = document.createElement('div');
            newOption.classList.add('variantOptions')
            newOption.innerHTML = `<label class="colorLabel">
                                        <input 
                                            type="text" 
                                            name="colorName_${this.variantAmount}"
                                            placeholder="Cor ${this.variantAmount}">
                                        <input 
                                            type="color"
                                            name="variantColor_${this.variantAmount}" /> 
                                            <i class="fa-solid fa-trash trash" @click="deleteOption($event.target)"></i>
                                    </label>`;
            console.log(newOption);
            this.optionsDiv.append(newOption)

        },
        deleteOption(target){ 
            target.parentElement.remove()
            this.variantAmount--;
         }
    }
}
export function categoryForm(){
    return { 
        type: 'parent',
        categories: null,
        init(){ this.getCategories() },
        async getCategories(){
            await axios.get('/category')
                .then((result) => {
                    this.categories = result.data
                }).catch((err) => {
                    alert(err)
                });
        }, 
    }
}
export function featureForm(){
    return {
        type: null,
        itemCount: 0,
        init(){
            this.$watch('type', (value)=>{
                if(this.itemCount == 0 && value == 'items') return this.addItem(true)
            })
        },
        plusIcon(){
            let icon = document.createElement('i')
            icon.classList.add('fa-solid')
            icon.classList.add('fa-add')
            icon.id = `addItemIcon`
            return icon;
        },
        trashCan(){
            let icon = document.createElement('i')
            icon.classList.add('fa-solid')
            icon.classList.add('fa-trash')
            return icon;
        },
        addItem(first){

            console.log('adding item')
            let div = this.$refs.items;
            let item = document.createElement('label')
            let input = document.createElement('input')
            let plusIcon = this.plusIcon()

            
            if(!first) {
                let icon = document.querySelector('#addItemIcon')
                icon.id = null
                icon.classList.remove('fa-add')
                icon.classList.add('fa-trash')
                icon.onclick = (e)=>{ this.removeItem(e.currentTarget.parentElement) }

            };

            input.id = `item_${this.itemCount}`;
            input.name = `item_${this.itemCount}`;

            item.innerText = '-'
            item.classList.add('item')
            item.appendChild(input)
            item.appendChild(plusIcon)

            this.itemCount++;
            div.appendChild(item)

            plusIcon.onclick = (e)=>{ this.addItem() }
            
        },
        removeItem(el){
            this.itemCount--;
            el.remove();
            let items = document.querySelectorAll('.item')
            let arr = Array.from(items)
            arr.forEach((el, index)=>{
                let input = el.querySelector('input')
                input.id = `item_${index}`
                input.name = `item_${index}`

            });
        },
        handleSubmit(){
            let form = this.$refs.form;

            if(this.type == 'text') form.action = "/feature"; 
            if(this.type == 'items') form.action = `/feature/${this.itemCount}`;

            form.submit()
        }

    };
}
export function productFeature(){
    return {
        features: null,
        product: 'null',
        feature: 'null',
        init(){
            this.getFeatures()
        },
        async getFeatures(){
            await axios.get('/feature')
                .then((result) => {
                    this.features = result.data;
                }).catch((err) => {
                    alert(err)
                });
        },
        reset(){
            this.product = 'null'
            this.feature = 'null'
        },
        handleSubmit(){
            if(this.feature == 'null' || this.product == 'null') return;


            this.$refs.form.submit();
        }
    }
}