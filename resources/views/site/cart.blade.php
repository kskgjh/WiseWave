@extends('layouts.mainLayout')

@section('links')
    <link rel="stylesheet" href="{{asset('css/cart.css')}}">
@endsection

@section('main')
@if(count($cart->items) > 0)    

    <div class="cart" x-data="cart">
        <section class="items">

            @foreach ($cart->items as $item)
                <div>
                    @if(str_contains($item->product->productImgs[0]->name, 'http'))
                        <img src="{{$item->product->productImgs[0]->name}}" alt="">
                    @else
                        <img src="asset/imgs/product/{{$item->product->productImgs[0]->name}}" alt="">
                    @endif
                    <div class="itemInfos">
                        <div class="left">
                            <span class="name">
                                <a href="/product/render/{{$item->product_id}}">
                                    {{ucwords($item->product->name)}}
                                </a>
                            </span>        
                            <span>Variação escolhida: {{ucwords($item->variantOption->option)}}</span>
                        </div>
                        <div class="right">
                            <span>{{$item->amount}}X de </span>
                            <span> R$ {{number_format($item->product->price, 2, ',', '.')}}</span>
                            <i class="fa-solid fa-trash" @click="confirmDelete({{$item->id}}, '{{$item->product->name}}')"></i>
                        </div>
                    </div>
                </div>
            @endforeach

        </section>

        <section class="final">
            <span>Produtos: {{$cart->item_amount}}</span>
            <span>Subtotal: R$ {{number_format($cart->total_price, 2, ',', '.')}}</span>
            
            <button class="btn-1">Comprar</button>
        </section>

        <div id="modal" x-show="modal" x-cloak>
            <div id="modalContent">
                <form action="{{route('cart.item.delete')}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" x-model="itemToDel" />
                    <input type="hidden" name="cart_id" value="{{$cart->id}}">
                    <h2>Tem certeza que deseja excluir <span x-ref="deleteName"></span> do seu carrinho? </h2>
                    <div class="rowDiv">
                        <button class="btn-1">Confirmar</button>
                        <button type="button" class="btn-2">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@else

    <section class="noItems">


    </section>

@endif



@endsection