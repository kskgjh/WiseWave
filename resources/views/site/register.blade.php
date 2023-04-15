@extends('layouts.mainLayout')

@section('title', "Cadastro")

@section('main')

<form 
    action='{{route('user.register')}}' 
    method="POST" 
    class="registerForm" 
    x-data="registerForm"> 
    @csrf
    @error('error')
        {{$message}}
    @enderror
    

    @livewire('site.register-user-form')

    @livewire('site.register-address-form')
    


    <div class="rowDiv">
        <button type='submit' class="btn-1">Cadastrar</button>
        <a href="{{url()->previous()}}" class="btn-2 btn-link">Voltar</a>
    </div>

</form>

@endsection