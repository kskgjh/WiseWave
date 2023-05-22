@extends('layouts.mainLayout');

@section('title', 'WiseWave - Entrar')

@section('main')


<div class="loginPage">
    <section class="loginMessage">
        <p>
            <h1>Por favor,</h1>
            para continuar comprando e aproveitando nosso site, entre em sua conta,
            <br>
            ou se ainda não tiver uma cadastre-se  
            <a href="{{route('register.render')}}">clicando aqui</a>
        </p>
    </section>

    @component('components.site.login-form' )@endcomponent
</div>
@endsection