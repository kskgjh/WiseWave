@extends('layouts.mainLayout')

@section('title', ucwords($product->name))

@section('links')
    <link rel="stylesheet" href="{{ asset('css/productPage.css') }}">
@endsection

@section('main')

    <section class="mainContent" x-data="productRequest">
        <div class="productImages">
            
            @if (str_contains($product->productImgs[0]->path, 'http'))
                <img x-ref="image" src="{{ $product->productImgs[0]->path }}" alt="">
                <div class="imgList">
                    @foreach ($product->productImgs as $image)
                        <img src="{{ $image->path }}" @click="changeImg('{{$image->path}}')" alt="">
                    @endforeach
                </div>
            @else
                <img x-ref="image" src="{{asset("assets/imgs/product/{$product->productImgs[0]->path} ")}}" alt="">
                <div class="imgList">
                    @foreach ($product->productImgs as $image)
                        <img @click="changeImg('{{$image->path}}')" src="{{asset("assets/imgs/product/$image->path")}}" alt="">
                    @endforeach
                </div>

            @endif

        </div>

        <div  class="productVariants">
            <h2>Escolha a {{ $product->variants->title }} desejada:</h2>
            <div x-ref="variants">
                @foreach ($variantOptions as $option)
                    <span @if ($loop->index == 0) class="selected" @endif @click="changeVariant({{$option->id}}, $event.currentTarget)">
                        {{ ucwords($option->option) }}
                    </span>
                @endforeach
            </div>
        </div>

        <form class="mainInfos" x-ref="form" method="post" >
            @csrf

            @if(session()->has('cart'))
                <span>{{session('cart')}}</span>
            @enderror

            <input type="hidden" x-ref="variantInput" name="variant" value="{{$variantOptions[0]->id}}">
            <input type="hidden" name="currentPrice" value="{{$product->price}}">
            <input type="hidden" name="product" value="{{$product->id}}">

            
            <h1>{{ucwords($product->name)}}</h1>
            

            <div class="amount">
                <span>{{ ucwords($product->name) }} já vendidos: {{ $product->sales }}</span>

                @if ($product->amount < 10)
                    <span>Restam apenas {{ $product->amount }} em estoque!!</span>
                @else
                    <span>Em estoque: {{ $product->amount }}</span>
                @endif
            </div>

            <div class="price">
                <label>
                    Quantidade
                    <input type="number" name="amount" value='1'>
                </label>
                <span>X</span>
                <div>
                    <h2>R$ {{number_format($product->price, 2, ',', '.')}}</h2>
                    <span>Ou apenas 10 vezes de R${{number_format(($product->price) / 10, 2, ',', '.')}} sem juros</span>
                </div>
            </div>
                <div>
                    <button type="button" 
                            @click="handleSubmit('buy')" 
                            class="btn-1">Comprar</button>
                    <button type="button" 
                            @click="handleSubmit('toCart')"
                            class="btn-2">Adicionar ao carrinho</button>
                </div>

        </form>

    </section>
    <scetion class="productDetails">
        <div>
            <h2>Descrição</h2>
            <p>{{$product->text}}</p>
        </div>
        @if(count($product->volumes) > 0)
            <div>
                <h2>Dimensões</h2>
                        <table class="dimTable">
                            <thead>
                                <tr>
                                    <th>UN</th>
                                    <th>Largura</th>
                                    <th>Comprimento</th>
                                    <th>Altura</th>
                                    <th>Peso (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->volumes as $volume)
                                    <tr>
                                        <th>{{$volume->amount}}</th>
                                        <th>{{$volume->width}}</th>
                                        <th>{{$volume->length}}</th>
                                        <th>{{$volume->height}}</th>
                                        <th>{{$volume->weight}}</th>
                                    </tr>
                                @endforeach
                                </tbody>
                        </table>

                    </div>
                
            </div>
        @endif

        @if(count($features) > 0)
            <div class="features">
                <h2>Características</h2>
                @foreach ($features as $feature)
                    @if(!empty($feature->text))    
                        <div>
                            <h3>- {{ucwords($feature->title)}}</h3>
                            <p>{{$feature->text}}</p>
                        </div>
                    @elseif(count($feature->items) > 0)
                        <div>
                            <h3>- {{ucwords($feature->title)}}</h3>
                            <ul class="featuresList">
                                @foreach ($feature->items as $item)
                                    <li>{{ucwords($item->item)}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </scetion>

@endsection
