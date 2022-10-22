<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_is_redirected_to_login()
    {
        $this->get(route('home'))->assertRedirect(route('login'));
    }

    /** @test */
    public function auth_user_can_see_home()
    {
        $this->actingAs(factory(User::class)->create())
            ->get(route('home'))->assertOk()->assertViewIs('home');
    }
}
