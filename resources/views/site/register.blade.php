<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">

    <title>Cadastro</title>
</head>
<body class="alignContentCenterScreen">

    <form action='{{route('user.register')}}' method="POST" class="form-1"> 
        @csrf
        @error('error')
            {{$message}}
        @enderror
        @error('userName') <span class="messageError">{{$message}}</span> @enderror
        <input 
            type='text' 
            autofocus
            placeholder='Nome completo' 
            name='userName' 
            @error('userName') class="invalidField" @enderror
            autocomplete="username" />

        @error('email') <span class="messageError">{{$message}}</span> @enderror
        <input 
            type='email' 
            placeholder='Email' 
            name='email' 
            @error('email') class="invalidField" @enderror
            autocomplete="email" />

        @error('password') <span class="messageError">{{$message}}</span> @enderror
        <input 
            type='password' 
            placeholder='Senha' 
            name='password'  
            @error('password') class="invalidField" @enderror
            autocomplete="new-password"/>

        @error('confirmPass') <span class="messageError">{{$message}}</span> @enderror
        <input 
            type='password' 
            id="password"
            placeholder='Confirme a senha' 
            name='password_confirmation' 
            @error('confirmPass') class="invalidField" @enderror
            autocomplete="new-password"/>
        <div>
            <label>Mostrar a senha
                <input type='checkbox' id='checkbox' />
            </label>
            <a href="{{route('user.auth')}}">Entrar</a>
        </div>
        <div class="rowDiv">
        <button type='submit' class="btn-1">Cadastrar</button>
        <a href="{{url()->previous()}}" class="btn-1 btn-link">Voltar</a>
        </div>
    </form>

    <script>
        check = document.getElementById('checkbox');
        passInput = document.getElementById('password');

        check.addEventListener('change', (e)=>{
            if (e.target.checked == true) {
                passInput.type= 'text'
                return 
            }
            passInput.type= 'password'
        });
    </script>
</body>
</html>