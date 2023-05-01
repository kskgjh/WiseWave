<div x-data="productList" 
     id="productTable"
     @add-product.window="addProduct($event)" 
     @current-page.window="getProducts($event)"
     @close-modal.window="toggleModal">
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
        <tr id="row_{{$product->id}}" @click="isSelected({{$product->id}})">
            <th>
                <input 
                    x-ref="check_{{$product->id}}" 
                    type="checkbox" 
                    @click.stop="select({{$product->id}})">
                {{$product->id}}
            </th>    
            <th>{{$product->name}}</th>    
            <th>{{$product->status}}</th>    
            <th>{{$product->amount}}</th>    
            <th>
                <form 
                    method="post" 
                    id="delForm_{{$product->id}}" 
                    action="{{route('product.delete', ['id'=> $product->id])}}" 
                    class="delForm"
                    @click.stop="handleDelForm({{$product->id}})">
                    @csrf 
                    @method('delete')
                    <i class="fa-solid fa-trash"></i>
                </form>
            </th>
        </tr>
        @endforeach
    </tbody>
    </table>
    {{$products->links('vendor.pagination.default')}}
    @endif
    <div x-show="modal" x-cloak>
        @component('components.admin.product.product-page')@endcomponent
    </div>
        
</div>
