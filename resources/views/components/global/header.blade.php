
<header id="header" x-data="header">
    <div class="left">
        @if (Request::getRequestUri() !== "/" )
        <a href="/" class="hoverEffect-1">Inicio</a>
        @endif
        <a href="" class="hoverEffect-1">Produtos</a>
        <a href="" class="hoverEffect-1">Fornecedores</a>
        <a href="" class="hoverEffect-1">Sobre nós</a>
        <a href="" class="hoverEffect-1">Contatos</a>
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
        @if (auth()->user()->admin)
        <span> | </span>
        @if (request()->route()->uri === 'admin')
        @component('components.admin.side-bar')@endcomponent 
        @else
        <a href="/admin">Painel</a>
        @endif
        @endif
    </div>
    @endauth
</header>

