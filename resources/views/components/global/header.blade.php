
<header id="header" x-data="header">
    <div class="left">
        <a href="/">
            <img class="icon" src="{{asset('assets/imgs/favicon.png')}}" alt="">
        </a>
        <a href="" class="hoverEffect-1">Produtos</a>
        <a href="" class="hoverEffect-1">Fornecedores</a>
        <a href="" class="hoverEffect-1">Sobre nós</a>
        <a href="" class="hoverEffect-1">Contatos</a>
    </div>

    <div class="search">
        <input type="search" name="search" class="hideSearchBar" x-ref="search" />
        <i class="fa-solid fa-search" @click="toggleSearchBar"></i>
    </div>
    @if(Request::getRequestUri() !== '/register' &&
        Request::getRequestUri() !== '/admin/register')
    @guest
    <div class="right">
        <div class="relative">
            <a class="cursor-pointer" x-on:mouseover="open = true">Entrar</a>
            <div @click.outside="toggle()" 
                 x-show="open"
                 x-cloak
                 x-transition:enter.duration.300ms
                 x-transition:leave.duration.500ms
                 x-transition:enter-start.scale.85
                 x-transition:enter-end.scale.100
                 x-transition:leave-start.scale.100
                 x-transition:leave-end.scale.85
                 class="dropMenu">
                        @component('components.site.login-form')@endcomponent
                </div>
        </div>

        <span>|</span>
        <a href="{{route('admin.register')}}">Cadastrar-se</a>
    </div>
    @endguest
    @endif

    @auth
    <div class="right">   
        <a href="/logout">Sair</a>
        @if(auth()->user()->admin && request()->route()->uri() !== 'admin')
            <span> | </span>
            <a href="/admin">Painel</a>
        @endif
        <span> | </span>
        @component('components.global.side-bar')
            @if(request()->route()->uri() == 'admin')
                <li id="overview"><a href="#overview">Resumos</a></li>
                <h2>Editar</h2>
                <li id="carrossel"><a href="/admin#carrossel">Carrossel</a></li>
                <li id="products"><a href="/admin#products">Produtos</a></li>
                <li id="features"><a href="/admin#features">Características</a></li>
                <li><a href="">Sobre nós</a></li>
                <li><a href="">Contatos</a></li>
            @else
                <li><a href="/cart">Meu carrinho</a></li>
                <li><a href="/cart">Meus pedidos</a></li>
                <li><a href="/cart">Endereços de entrega</a></li>
                <li><a href="/cart">Meu carrinho</a></li>
                <li><a href="/cart">Meu carrinho</a></li>
            @endif
        @endcomponent 
    </div>
    @endauth
</header>

