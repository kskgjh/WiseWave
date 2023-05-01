@extends('layouts.mainLayout')

@section('title', $product->name)

@section('links')
    <link rel="stylesheet" href="{{ asset('css/productPage.css') }}">
@endsection

@section('main')

    <section class="mainContent">
        <div class="productImages">
            
            @if (str_contains($product->productImgs[0]->name, 'http'))
                <img src="{{ $product->productImgs[0]->name }}" alt="">
                <div class="imgList">
                    @foreach ($product->productImgs as $image)
                        <img src="{{ $image->name }}" alt="">
                    @endforeach
                </div>
            @else
            <img src="{{asset("assets/imgs/product/{$product->productImgs[0]->name} ")}}" alt="">
                <div class="imgList">
                    @foreach ($product->productImgs as $image)
                        <img src="{{asset("assets/imgs/product/$image->name")}}" alt="">
                    @endforeach
                </div>

            @endif

        </div>

        <form class="mainInfos" action="">
            <input type="hidden" name="variant">
            <input type="hidden" name="product" value="{{$product->id}}">

            <div class="price">
                {{ucwords($product->name)}} - 
                R$ <span>{{ $product->price }}</span>
            </div>

            <div class="amount">
                <span>{{ ucwords($product->name) }} já vendidos: {{ $product->sales }}</span>

                @if ($product->amount < 10)
                    <span>Restam apenas {{ $product->amount }} em estoque!!</span>
                @else
                    <span>Em estoque: {{ $product->amount }}</span>
                @endif
            </div>

            <div class="productVariants">
                <h2>Escolha a {{ $product->variants->title }} desejada:</h2>
                <div>
                    @foreach ($variantOptions as $option)
                        <span @if ($loop->index == 0) class="selected" @endif>
                            {{ ucwords($option->option) }}
                        </span>
                    @endforeach
                </div>
            </div>
                <label>
                    Quantidade
                    <input type="number" name="amount" value='1'>
                </label>

                <div>
                    <button type="submit" class="btn-1">Comprar</button>
                    <button type="button" class="btn-2">Adicionar ao carrinho</button>
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
                        <table>
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
    </scetion>

@endsection
