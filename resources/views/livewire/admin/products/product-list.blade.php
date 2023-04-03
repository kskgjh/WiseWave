<div x-data="productList()" 
     @add-product.window="addProduct($event)" 
     id="productTable">

@if(count($products) > 0)
    <div class="tableHeader">
        <label class='checkAll'>
            <input @change="selectAll($event.target)" x-ref="checkAll" x-bind:checked="somethingSelected" type="checkbox">
            Marcar todos
            <span x-text="howManySelected"></span>
        </label>
        <span @click="delSelected" x-show="somethingSelected" x-cloak class="removeAll">Remover Selecionados</span>
    </div>
    <table class="productList" >
        <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Status</th>
            <th>Estoque</th>
            <th>Excluir</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
        <tr @click="isSelected({{$product->id}})">
            <th>
                <input 
                    x-ref="check_{{$product->id}}" 
                    type="checkbox" 
                    @click.stop="select({{$product->id}}, {{$loop->index}})">
                {{$product->id}}
            </th>    
            <th>{{$product->name}}</th>    
            <th>{{$product->status}}</th>    
            <th>{{$product->amount}}</th>    
            <th>
                 <a @click.stop href="{{route('product.delete', ['id'=> $product->id])}}"> 
                    <i class="fa-solid fa-trash"></i>
                </a>
            </th>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{$products->links('vendor.pagination.default')}}
    @endif
    
        <div x-show="modal" x-cloa>
            <form action="" class="productModal">
                <div class="updateTitle">
                    <i class="closeButton fa-solid fa-arrow-left-long" @click="toggleModal"></i>

                    <h1 x-ref="productName"></h1>
                    
                    <template x-if="currentStatus">
                        <label for="currentStatus">
                            Ativo
                            <i class="fa-regular fa-square-check"></i>    
                        </label>
                    </template>
                    <template x-if="!currentStatus">
                        <label for="currentStatus">
                            Desativado
                            <i class="fa-regular fa-square"></i>    
                        </label>
                    </template>
                    <input 
                        type="checkbox" 
                        class="hidden" 
                        id="currentStatus"
                        x-model="currentStatus">
                </div>

                <div class="productModalMain">
                    <div class="productModalImages">
                        <img class="productCurrentImg" x-ref="currentImg" :src="currentImg">
                        <div x-ref="images"></div>
                    </div>
                    <div class="productInfos">

                        <label>Em estouque: 
                            <input type="number" x-ref="amount" name="amount" />
                        </label>
                        <label x-ref="variant_label">Variante:
                            <select name="variant_id" x-model="currentVariant">
                                    <option value="null">Selecionar uma variante</option>
                                @foreach ($variants as $variant)
                                    <option value="variant_{{$variant_id}}">{{$variant->title}}</option>    
                                @endforeach
                            </select>   
                        </label>

                        <label class="desc">Descrição: 
                            <textarea x-ref="text" rows="8" cols="20"></textarea>
                        </label>
                    </div>
                </div>
                        <div class="dimensions" id="dimensions">
                            <button class="btn-1" type="button" @click="addDimensions($event)">
                                Incluir dimensões 
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                    <div class="buttonsDiv">
                        <button class="btn-1">Atualizar</button>
                        <button type="button" class="btn-1" @click="window.location.reload()">Cancelar</button>
                    </div>
            </form>
            </div>
<script>

      function productList(){
            return {
                products: @js($products).data,
                somethingSelected: false, 
                howManySelected: 0,
                modal: false,
                selected: [],
                volumes: 0,

                currentVariant: null,
                currentImg: null,
                currentStatus: null,
            toggleModal(){
                this.modal = !this.modal
                this.scrollLock()
            },
            productPage(id){
                    let index = this.products.findIndex((el, index, arr)=>{
                            if(el.id == id) return true
                    })
                    let detectUrl = new RegExp('^https:\/\/')
                    console.log(detectUrl)
                    let product = this.products[index]
                    console.log(product)
                    let productImages = product.product_imgs
                    let imageDiv = this.$refs.images

                    if(detectUrl.test(productImages[0].name)){
                        this.currentImg = productImages[0].name
                    }else{
                        this.currentImg = `assets/imgs/product/${productImages[0].name}`
                    }

                    this.$refs.productName.innerText = product.name
                    this.$refs.amount.value = product.amount
                    this.$refs.text.value = product.text


                    if(product.status == true){
                        this.currentStatus = true
                    }

                    if(product.variants_id){
                    axios.get(`http://localhost:8000/product/variant/${product.variants_id}`)
                        .then((result) => {
                            this.currentVariant = `variant_${result.data.id}`
                        }).catch((err) => {
                            this.$refs.variant_label.innerHTML = 'Ocorreu um problema com a variação do produto, tente novamente mais tarde.'
                        });
                    } else{
                        this.currentVariant = 'null'
                    }
                    
                    this.$refs.images.innerHTML = ""
                    productImages.forEach(element => {

                        let image = document.createElement('img')
                        if(detectUrl.test(element.name)){
                            image.src = element.name
                        }else{
                            image.src = `assets/imgs/product/${element.name}`
                        }
                        let span = document.createElement('span')
                        span.appendChild(image)
                        
                        imageDiv.appendChild(span)
                    });
                    this.toggleModal()
                },
            scrollLock(){
                let body = document.querySelector('body')
                if(body.classList.contains('scrollLock')){
                    return body.classList.remove('scrollLock')
                }
                body.classList.add('scrollLock')
            },
            init(){
                document.addEventListener('keyup', e =>{ 
                    if(e.key == 'Escape' && this.modal)this.toggleModal()
                })
            },
            addProduct(e){
                    let product = e.detail.product
                    let images = e.detail.images
                    product.images = images
                    this.products.push(product)                    
                },
                aaa(e){console.log(e)},
            select(id){ 
                console.log(`select id: ${id}`)
                const checkbox = this.$refs[`check_${id}`]
                    if(checkbox.checked == false){
                        let index = this.selected.indexOf(id)
                        this.selected.splice(index, 1)
                        
                    }else {
                        this.selected.push(id)
                        checkbox.checked = true
                    }
                    this.selected.length <= 0?this.somethingSelected = false:this.somethingSelected = true
                    this.howManySelected = this.selected.length
                },
            isSelected(id){
                    const checkbox = this.$refs[`check_${id}`]
                    if(checkbox.checked) return this.productPage(id)
                    checkbox.checked = true
                    this.select(id)
                },
            selectAll(el){
                if(el.checked){
                    this.somethingSelected = true
                    for(let i = 0; i<this.products.length; i++){
                        let id = this.products[i].id
                        let checkboxName = `check_${id}`
                        let checkbox = this.$refs[checkboxName]
                        if (!checkbox.checked){
                            checkbox.checked = true
                            this.selected.push(id)
                        }
                    }
                    this.howManySelected = this.selected.length

                    return 
                }
                    this.somethingSelected = false
                    this.selected = []
                    for(let x = 0; x<this.products.length; x++){
                            let id = this.products[x].id
                            let checkboxName = `check_${id}`
                            let checkbox = this.$refs[checkboxName]
                            if (checkbox.checked){
                                checkbox.checked = false
                            }
                    }
                    this.howManySelected = this.selected.length
                    
                },
            delSelected(){
                    this.selected.forEach((id)=>{
                        let index = this.products.findIndex((el, index, arr)=>{
                            if(el.id == id) return true
                        })
                        console.log('deleting index ',index, "id: ",id)
                        this.products.splice(index, 1)
                    })
                    Livewire.emit('delSelected', this.selected)
                    this.selected = []
                    this.somethingSelected = false
                    this.$refs.checkAll.checked = false
                    this.howManySelected = this.selected.length

                },
            addDimensions(e){
                let el = e.target
                let elParent = el.parentElement
                
                if(el.classList.contains('fa-plus')){
                    el.remove()
                    let trashCan = document.createElement('i')
                    trashCan.classList.add('fa-solid')
                    trashCan.classList.add('fa-trash')
                    elParent.appendChild(trashCan)
                    trashCan.addEventListener('click', e => e.target.parentElement.remove())
                }else{
                    el.remove()
                }

                let div = document.getElementById('dimensions')
                console.log(div)

                let span = document.createElement('span')
                span.innerText = `Volume ${this.volumes + 1}(em cm): `

                let height = document.createElement('input')
                height.type = 'number'
                height.name = `height_${this.volumes}`

                let width = document.createElement('input')
                width.type = 'number'
                width.name = `width_${this.volumes}`

                let length = document.createElement('input')
                length.type = 'number'
                length.name = `length_${this.volumes}`

                let labelHeight = document.createElement('label')
                let labelWidth = document.createElement('label')
                let labelLength = document.createElement('label')

                labelHeight.innerText = "Altura: "
                labelHeight.appendChild(height)

                labelWidth.innerText = "Largura: "
                labelWidth.appendChild(width)

                labelLength.innerText = "Comprimento: "
                labelLength.appendChild(length)

                let addVolume = document.createElement('i')
                addVolume.classList.add('fa-solid')
                addVolume.classList.add('fa-plus')

                let volume = document.createElement('div')
                volume.appendChild(span)
                volume.appendChild(labelHeight)
                volume.appendChild(labelWidth)
                volume.appendChild(labelLength)
                volume.appendChild(addVolume)
                volume.classList.add('volume')

                div.appendChild(volume)

                this.volumes++

                addVolume.addEventListener('click', e => this.addDimensions(e))
            }
            }
        }
</script>

    </div>
</div>
