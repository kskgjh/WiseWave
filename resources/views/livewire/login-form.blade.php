

<form action="{{route('user.auth')}}" method="POST" class="form-1">
    @csrf
    @error('email')
        <span>{{$message}}</span>
    @enderror
    <input
        type="email" 
        placeholder="Email"
        autocomplete="email"
        @isset($email)
        value='{{$email}}'
        @endisset
        name='email' />


    @error('password')
        <span>Por favor, insira uma senha</span>
    @enderror
    <input
    type="password" 
    placeholder="Senha"
    @isset($email)
        autofocus
    @endisset
    autocomplete="password"
    name='password'
    id='password' />
    <div>

    <a href="{{route('register.render')}}">Cadastrar-se</a>
    </div>

    <button class="btn-1">Enviar</button>

</form>
