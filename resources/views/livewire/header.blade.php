
<header id="header">
    <div class="left">
        @if (Request::getRequestUri() !== "/" )
        <a href="/" class="hoverEffect-1">Inicio</a>
        @endif
        <a href="" class="hoverEffect-1">Produtos</a>
        <a href="" class="hoverEffect-1">Fornecedores</a>
        <a href="" class="hoverEffect-1">Sobre nós</a>
        <a href="" class="hoverEffect-1">Contatos</a>
    </div>

    @guest
    <div class="right">
        <div class="dropDown" x-data="dropDown()">
            <a class="cursor-pointer" x-on:mouseover="open = true">Entrar</a>
                <div x-show="open" x-on:click.outside="toggle()" class="dropMenu">
                    @livewire('login-form')
                </div>
        </div>

        <span>|</span>
        <a href="/register">Cadastrar-se</a>
    </div>
    @endguest

    @auth
    <div class="right">   
        <a href="/logout">Sair</a>
        @if (auth()->user()->admin)
        <span> | </span>
        @if (Request::getRequestUri() === '/admin')
            @livewire('admin.side-bar')
        @else
        <a href="/admin">Painel</a>
        @endif
        @endif
    </div>
    @endauth
    <script>
        function dropDown(){
            return {
                open: false,
                toggle() { this.open = !this.open }
            }
        }

    </script>
</header>

