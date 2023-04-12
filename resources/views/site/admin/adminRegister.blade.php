@extends('layouts.mainLayout')
@section('links')
<link rel="stylesheet" href="{{asset('css/adminPanel.css')}}">
@endsection
@section('title', 'Cadastro de Admin')

@section('main')

    <form class="adminForm" method="post" action="{{route('admin.register.submit')}}">
        @csrf
        <input type="text" name="userName" placeholder="Nome">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="Senha">
        <button class="btn-1">Enviar</button>
    </form>

@endsection