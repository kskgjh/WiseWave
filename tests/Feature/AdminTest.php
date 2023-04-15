<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /** @test */
    public function admin_panel_test(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/');
    }
}
