<div class="userInputs">
    @error('userName') <span class="messageError">{{$message}}</span> @enderror
    <input 
        type='text' autofocus
        dusk="userName"
        placeholder='Nome completo'  
        name='userName' autocomplete="username" 
        @error('userName') class="invalidField" @enderror />

    @error('email') <span class="messageError">{{$message}}</span> @enderror
    <input 
        type='email' placeholder='Email'
        name='email' autocomplete="email"
        dusk="email"
        @error('email') class="invalidField" @enderror />

    <input 
        @error('cpf') class="invalidField" @enderror
        dusk="cpf"
        x-mask="999.999.999-99" type="text"
        placeholder="CPF" name="cpf" />
    <input         
        placeholder="Celular" 
        dusk="phone"
        type="text" name="phone"
        x-mask="(99) 99999-9999" />
        
        
    @error('password') <span class="messageError">{{$message}}</span> @enderror
    <div class="relative">
    <input 
        @error('password') class="invalidField" @enderror
        :type="!showpassword? 'password' : 'text'" name='password'  
        placeholder='Senha' dusk="password"
        autocomplete="new-password"/>
        <i class="inputIcon" :class="showpassword? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash'" @click="togglePassword"></i>
    </div>
    @error('confirmPass') <span class="messageError">{{$message}}</span> @enderror
    <input 
        @error('confirmPass') class="invalidField" @enderror
        type='password' placeholder='Confirme a senha' dusk="passoword_confirmation"
        name='password_confirmation' autocomplete="new-password"/>
</div>
