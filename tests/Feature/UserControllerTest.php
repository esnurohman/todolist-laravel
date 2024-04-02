<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginForMember()
    {
        $this->withSession([
            "user" => "esnur"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSucces()
    {
        $this->post('/login', [
            "user" => "esnur",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "esnur");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "esnur"
        ])->post('/login', [
            "user" => "esnur",
            "password" => "rahasia"
        ])->assertRedirect("/");
        
    }
    
    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }
    public function testLoginFailed()
    {
        $this->post('login', [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "esnur"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testGuestLogout()
    {
        $this->post('/logout')
        ->assertRedirect("/");
    }
}
