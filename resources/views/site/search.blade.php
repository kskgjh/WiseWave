@extends('layouts.mainLayout')
@section('title', 'Produtos')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('main')

    <form action="{{ route('product.search') }}" method="post">
        @csrf
        <section class="filters" x-data="searchFilters" @search-text.window="getSearchBar($event)">

            <input type="hidden" x-model="search" name="searchText">
            <input type="hidden" name="category_id" x-model="category_id">

            <div class="orderby">
                <h3>Ordenar por</h3>
                <select name="orderby">
                    <option value="default" @if (empty($filters->orderby)) select @endif>Selecionar</option>
                    <option value="popularity" @if ($filters->orderby == 'popularity') select @endif>Popularidade</option>
                    <option value="lowerPrice" @if ($filters->orderby == 'lowerPrice') select @endif>Menor preço</option>
                    <option value="biggerPrice" @if ($filters->orderby == 'biggerPrice') select @endif>Maior preço</option>
                    <option value="newer" @if ($filters->orderby == 'newer') select @endif>Novidades</option>
                </select>
            </div>

            <div class="prices">
                min_value= {{$filters->min_value}} max_value= {{$filters->max_value}}
                <h3>Filtrar preços</h3>
                @if (session()->has('price'))
                    <span>{{ session('price') }}</span>
                @endif
                <label for="min_value">
                    A partir de
                    R$<span x-text="min_value"></span>,00
                </label>
                <input type="range" x-model="min_value" name="min_value" min="0" max="2000" @if($filters->min_value) value="{{$filters->min_value}}" @endif>

                <label for="max_value">
                    Até
                    R$<span x-text="max_value"></span>,00
                </label>
                <input type="range" x-model="max_value" name="max_value" min="0" max="2000" @if($filters->max_value) value="{{$filters->max_value}}" @endif>

            </div>

            <div class="categories" x-ref="categoryList">
                <h3>Filtrar por categoria</h3>
                <div>
                    @foreach ($categories as $category)
                        @if (count($category->children) > 0)
                            <div class="parentCategories" @click="selectCategory($event)">
                                <h4 @if ($filters->category_id == $category->id) class="categorySelected" @endif
                                    id="{{ $category->id }}">{{ ucwords($category->name) }}</h4>
                                <div class="childrens">

                                    @foreach ($category->children as $children)
                                        <span @if ($filters->category_id == $children->id) class="categorySelected" @endif
                                            id="{{ $children->id }}">{{ $children->name }}</span>
                                    @endforeach

                                </div>
                            </div>
                        @elseif($category->type !== 'children')
                            <h4 @if ($filters->category_id == $category->id) class="categorySelected" @endif id="{{ $category->id }}">
                                {{ ucwords($category->name) }}</h4>
                        @endif
                    @endforeach

                </div>
            </div>
            <div>
                <button class="btn-1">Buscar</button>
                <button class="btn-2" type="button">Limpar filtros</button>
            </div>
        </section>
    </form>

    <section class="mainContent" x-data="productSearch" x-ref="component"
        @if (!empty($filters->searchText)) data-search="{{ $filters->searchText }}" @endif>
        <input type="search" name="search" @keyup.debounce="searching" x-model="search"
            placeholder="Pesquisar por nome de produto...">


        <div x-ref="productList">
            @foreach ($products as $product)
                <a href="/product/render/{{ $product->id }}" class="productCard">
                    <span>
                        @if (str_contains($product->productImgs[0]->path, 'http'))
                            <img src="{{ $product->productImgs[0]->path }}" alt="">
                        @else
                            <img src="/assets/imgs/product/{{ $product->productImgs[0]->path }}" alt="">
                        @endif
                    </span>
                    <h3>{{ ucwords($product->name) }}</h3>
                    <div>
                        <label>
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </label>
                        <label>
                            Vendidos: {{ $product->amount }}
                        </label>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

@endsection
