<div x-data="productList()" @add-product.window="addProduct($event)" id="productTable">
@if(count($products) > 0)
    <div class="tableHeader">
        <label class='checkAll'>
            <input @change="selectAll($event)" x-ref="checkAll" x-bind:checked="somethingSelected" type="checkbox">
            Marcar todos
        </label>
        <span @click="delSelected" x-show="somethingSelected" x-cloak class="removeAll">Remover Selecionados</span>
    </div>
    {{$msg}}
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
                 <a @click.stop href="{{route('delete.product', ['id'=> $product->id])}}"> 
                    <i class="fa-solid fa-trash"></i>
                </a>
            </th>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{$products->links('vendor.pagination.default')}}
    @endif
    
    <div id="modal" x-show="modal" x-cloak>
        <div id="modalContent" class="productModal" @click.outside="toggleModal">
            <h1 x-ref="productName"></h1>
            <div class="productModalMain">
                <div x-ref="images"></div>
                <div class="productInfos">
                    <label>Status: 
                        <p x-ref="status"></p>
                    </label>
                    <label>Em estouque: 
                        <p x-ref="amount"></p>
                    </label>
                    <label class="desc">Descrição: 
                        <p x-ref="text"></p>
                    </label>
                    <label>Variante:
                        <p x-ref="variant"></p>   
                    </label>

                </div>
            </div>
        </div>
    </div>

    <script> 
        function productList(){
            return {
                modal: @entangle('modal'),
                somethingSelected: false, 
                selected: [],
                products: @js($products).data,
            toggleModal(){this.modal = !this.modal},
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
                },
            isSelected(id){
                    const checkbox = this.$refs[`check_${id}`]
                    if(checkbox.checked) return this.productPage(id)
                    checkbox.checked = true
                    this.select(id)

                },
            selectAll(event){
                if(event.target.checked){
                    this.somethingSelected = true
                    for(let i = 0; i<this.products.length; i++){
                        let id = this.products[i].id
                        let checkboxName = `check_${i}`
                        let checkbox = this.$refs[checkboxName]

                        if (!checkbox.checked){
                            checkbox.checked = true
                            this.selected.push(id)
                        }
                    }
                    return 
                }
                    this.somethingSelected = false
                    this.selected = []
                    for(let x = 0; x<this.products.length; x++){
                            let checkboxName = `check_${x}`
                            let checkbox = this.$refs[checkboxName]

                            if (checkbox.checked){
                                checkbox.checked = false
                            }

                    }
                    
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
                },
            productPage(id){
                    let index = this.products.findIndex((el, index, arr)=>{
                            if(el.id == id) return true
                    })
                    let product = this.products[index]
                    console.log(product)
                    let productImages = product.product_imgs
                    let imageDiv = this.$refs.images

                    this.$refs.productName.innerText = product.name
                    this.$refs.amount.innerText = product.amount
                    this.$refs.text.innerText = product.text
                    this.$refs.status.innerText = product.status ==1?'Ativo':'Desativado'

                    if(product.variants_id){
                    axios.get(`http://localhost:8000/product/variant/${product.variants_id}`)
                        .then((result) => {
                            this.$refs.variant.innerText = result.data.title
                        }).catch((err) => {
                            this.$refs.variant.innerText = 'Ocorreu um problema com a variação do produto, tente novamente mais tarde.'
                        });
                    } else{
                        this.$refs.variant.innerText = 'Não possuí.'
                    }
                    
                    this.$refs.images.innerHTML = ""
                    productImages.forEach(element => {
                        let image = document.createElement('img')
                        image.src = `assets/imgs/product/${element.name}`

                        let span = document.createElement('span')
                        span.appendChild(image)
                        
                        imageDiv.appendChild(span)
                    });

                    this.modal = true
                }
            }
        }

    </script>
</div>
