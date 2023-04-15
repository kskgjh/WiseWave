

<form action="{{route('user.auth')}}" method="POST" class="loginForm">
    @csrf
    @error('email')
        <span>{{$message}}</span>
    @enderror
    <input
        type="email" 
        placeholder="Email"
        autocomplete="email"
        name='email'
        autofocus />
        

    @error('password')
        <span>Por favor, insira uma senha</span>
    @enderror
    <input
    type="password" 
    placeholder="Senha"
    autocomplete="password"
    name='password'
    id='password' />

    <button class="btn-1">Enviar</button>
    <a class="btn-link btn-2" href="{{route('register.render')}}">Cadastrar-se</a>

</form>
