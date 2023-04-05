export function adminSelector(){
    return {
        current: 'Resumos',
        changePage(event){
            console.log(event)
            this.current = event.detail
        },
        init(){
            let url = window.location.href

            if(url.match('carrossel')) return this.current = 'Carrossel'
            if(url.match('overview')) return this.current = 'Resumos'

            let params = new URLSearchParams(window.location.search)
            
            if(params.get('page')) return this.current = 'Produtos'

        }

    }
}
export function adminSideBar(){
    return {
        hidden: false,
        toggleSideBar(){this.hidden = !this.hidden},
        toggleSelected(target){
            let listEl = document.querySelector("#sideBarMenu");
            let list = listEl.children 
            let arr = Array.from(list)

            if(target == listEl) return 

            arr.forEach((element)=> {
                if(element.classList.contains('selected')) element.classList.remove('selected');
            })

            target.classList.add('selected')
            let event = new CustomEvent('change-page', {detail: target.innerText})
            dispatchEvent(event)
        }
    }
}
export function productList() {
    return {
        products: [],
        somethingSelected: false,
        howManySelected: 0,
        modal: false,
        selected: [],
        volumes: 0,
        page: null,

        currentVariant: null,
        currentImg: null,
        currentStatus: null,
        toggleModal() {
            this.modal = !this.modal;
            this.scrollLock();
        },
        init() {
            document.addEventListener("keyup", (e) => {
                if (e.key == "Escape" && this.modal) this.toggleModal();
            });

            let params = new URLSearchParams(window.location.search)
            this.page = params.get('page')
            this.getProducts()            
        },
        async getProducts() {
            console.log("serch for page: ",this.page)
            await axios
                .get(`http://localhost:8000/product/all/?page=${this.page}`)
                .then((result) => {
                    console.log(result);
                    this.products = result.data.data;
                })
                .catch((err) => {
                    alert(err);
                });
        },
        productPage(id) {
            let index = this.products.findIndex((el, index, arr) => {
                if (el.id == id) return true;
            });
            let detectUrl = new RegExp("^https://");
            console.log(detectUrl);
            let product = this.products[index];
            console.log(product);
            let productImages = product.product_imgs;
            let imageDiv = this.$refs.images;

            if (detectUrl.test(productImages[0].name)) {
                this.currentImg = productImages[0].name;
            } else {
                this.currentImg = `assets/imgs/product/${productImages[0].name}`;
            }

            this.$refs.productName.innerText = product.name;
            this.$refs.amount.value = product.amount;
            this.$refs.text.value = product.text;

            if (product.status == true) {
                this.currentStatus = true;
            }

            if (product.variants_id) {
                axios
                    .get(
                        `http://localhost:8000/product/variant/${product.variants_id}`
                    )
                    .then((result) => {
                        this.currentVariant = `variant_${result.data.id}`;
                    })
                    .catch((err) => {
                        this.$refs.variant_label.innerHTML =
                            "Ocorreu um problema com a variação do produto, tente novamente mais tarde.";
                    });
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
                let span = document.createElement("span");
                span.appendChild(image);

                imageDiv.appendChild(span);
            });
            this.toggleModal();
        },
        scrollLock() {
            let body = document.querySelector("body");
            if (body.classList.contains("scrollLock")) {
                return body.classList.remove("scrollLock");
            }
            body.classList.add("scrollLock");
        },
        addProduct(e) {
            console.log(e)
            let product = e.detail.product;
            let images = e.detail.images;
            product.images = images;
            this.products.push(product);
        },
        aaa(e) {
            console.log(e);
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
        isSelected(id) {
            console.log(this.page)
            const checkbox = this.$refs[`check_${id}`];
            if (checkbox.checked) return this.productPage(id);
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
        delSelected() {
            this.selected.forEach((id) => {
                let index = this.products.findIndex((el, index, arr) => {
                    if (el.id == id) return true;
                });
                console.log("deleting index ", index, "id: ", id);
                this.products.splice(index, 1);
            });
            Livewire.emit("delSelected", this.selected);
            this.selected = [];
            this.somethingSelected = false;
            this.$refs.checkAll.checked = false;
            this.howManySelected = this.selected.length;
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
                    e.target.parentElement.remove()
                );
            } else {
                el.remove();
            }

            let div = document.getElementById("dimensions");
            console.log(div);

            let span = document.createElement("span");
            span.innerText = `Volume ${this.volumes + 1}(em cm): `;

            let height = document.createElement("input");
            height.type = "number";
            height.name = `height_${this.volumes}`;

            let width = document.createElement("input");
            width.type = "number";
            width.name = `width_${this.volumes}`;

            let length = document.createElement("input");
            length.type = "number";
            length.name = `length_${this.volumes}`;

            let labelHeight = document.createElement("label");
            let labelWidth = document.createElement("label");
            let labelLength = document.createElement("label");

            labelHeight.innerText = "Altura: ";
            labelHeight.appendChild(height);

            labelWidth.innerText = "Largura: ";
            labelWidth.appendChild(width);

            labelLength.innerText = "Comprimento: ";
            labelLength.appendChild(length);

            let addVolume = document.createElement("i");
            addVolume.classList.add("fa-solid");
            addVolume.classList.add("fa-plus");

            let volume = document.createElement("div");
            volume.appendChild(span);
            volume.appendChild(labelHeight);
            volume.appendChild(labelWidth);
            volume.appendChild(labelLength);
            volume.appendChild(addVolume);
            volume.classList.add("volume");

            div.appendChild(volume);

            this.volumes++;

            addVolume.addEventListener("click", (e) => this.addDimensions(e));
        },
    };
}
export function carrousselForm(){
    return {
        imagePath: null,
        getPath(e){
            if(e.target.files.length == 0) return
            let file = e.target.files[0]
            console.log(file)
            const reader = new FileReader
            reader.readAsDataURL(file)
            reader.onload = ev=> { this.imagePath = ev.target.result }

        },
    }
}
export function currentCarroussel(){
    return {
        currentTitle: null,
        currentAlt: null,
        currentImg: null,
        currentId: null,
        modal: false,
        hovering: false,
        images: [],
        init(){
            console.log('current carroussel init')
            this.getImgs()
        },
        toggleModal(){this.modal = !this.modal},
        async getImgs(){
            await axios.get("http://localhost:8000/banner")
                .then((result) => {
                    console.log(result)
                    if(!result.data[0]) return;
                    this.images = result.data;
                    this.currentImg = `assets/imgs/carroussel/${result.data[0].path}`;
                    this.currentId = result.data[0].id;
                    this.currentTitle = result.data[0].title;
                    this.currentAlt = result.data[0].alt;
                }).catch((err) => {
                    console.log(err)
                    alert('Ocorreu um problema ao buscar os banners, por favor recarregue a peagina');
                });
        },
        changeImg(path, id){
            this.currentId = id
            this.currentImg = `assets/imgs/carroussel/${path}`
        },
        deleteImg(){
            this.toggleModal()
        }
    }
}
