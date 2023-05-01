<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    /* * @test */
    public function test_register_user_is_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register');
            $browser->type('userName', 'inacio junior');
            $browser->type('email', 'teste@teste.com');
            $browser->type('cpf', '133.465.619-33');
            $browser->type('phone', '(45) 99106-7182');
            $browser->type('password', 'password');
            $browser->type('password_confirmation', 'password');
            $browser->type('cep', '85890-000');
            $browser->click("@cep_search");
            $browser->type('neighborhood', 'São Francisco');
            $browser->type('street', 'Rua ArthurFollmann');
            $browser->type('number', '297');
            $browser->press('Cadastrar');
            $browser->assertPathIs('/');
        });
}
}