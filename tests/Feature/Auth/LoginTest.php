<?php

namespace Tests\Feature\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_see_login_page()
    {
        $this->get('/login')->assertOk()->assertViewIs('auth.login');
        $this->assertGuest();
    }

    /** @test */
    public function a_valid_user_can_login()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_email()
    {
        $data_sets = [
            ['email' => 'invalid@email.com', 'password' => 'password'],
            ['email' => '', 'password' => 'password'],
            ['email' => 'invalidemailcom', 'password' => 'password']
        ];
        foreach ($data_sets as $data_set){
            $response = $this->post('/login', $data_set);
            $response->assertSessionHasErrors('email');//any credentials errors will be sent in email
            if($data_set['email']){
                $this->assertTrue(session()->hasOldInput('email'));
            }
            $this->assertFalse(session()->hasOldInput('password'));
            $this->assertGuest();
        }
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_password()
    {
        $user = factory(User::class)->create();
        $data_sets = [
            ['email' => $user->email, 'password' => 'differentPassword'],
            ['email' => $user->email, 'password' => '']
        ];
        foreach($data_sets as $data_set){
            $response = $this->post('/login', $data_set);
            if($data_set['password']){
                $response->assertSessionHasErrors('email');//any credentials errors will be sent in email
            }else{
                $response->assertSessionHasErrors('password');
            }
            $this->assertTrue(session()->hasOldInput('email'));
            $this->assertFalse(session()->hasOldInput('password'));
            $this->assertGuest();
        }
    }

    /** @test */
    public function authenticated_user_cannot_see_login_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/login')->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function authenticated_user_cannot_send_login_credentials()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->post('/login')->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function deactivated_employee_cannot_login()
    {
        $employee = factory(Employee::class)->create(['active'=>0])->load('user');
        $data = ['email'=>$employee->user->email, 'password'=>'password'];
        $response = $this->post('/login', $data);
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

}
