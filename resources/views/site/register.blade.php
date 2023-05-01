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
    

    @component('components.site.register-user-form')@endcomponent

    @component('components.site.register-address-form')@endcomponent
    
    <div class="rowDiv">
        <button type='submit' class="btn-1">Cadastrar</button>
        <a href="{{route('index')}}" class="btn-2 btn-link">Voltar</a>
    </div>
</form>
@endsection