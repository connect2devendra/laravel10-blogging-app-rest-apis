<?php

namespace Tests\Unit\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;


class UserControllerTest extends TestCase
{
    use DatabaseTransactions;      

    public function test_non_authenticated_user_cannot_get_user_details()
    {   
        $response = $this->json('GET', route('auth.user'), ['Accept' => 'application/json']);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_authenticated_user_can_get_user_details()
    {
        // Sanctum::actingAs(
        //     User::first(),
        // );

        $user = User::factory()->create();
        Sanctum::actingAs($user,);

        $response = $this->json('GET', route('auth.user'), ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function non_authenticated_user_cannot_logout()
    {
        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(401)
            ->assertSee('Unauthenticated');;
    }

    public function authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(200);
    }

    public function return_validation_error_when_email_doenot_exist()
    {
        $response = $this->json('POST', route('password.email'), ['email' => 'invalid@email.com']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function send_password_reset_link_if_email_exists()
    {
        $user = User::first();
        $response = $this->json('POST', route('password.email'), ['email' => $user->email]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    public function reset_password_success()
    {
        $user = User::first();
        $token = Password::broker()->createToken($user);
        $new_password = 'testpassword';

        $response = $this->json('POST', route('password.reset'), [
            'token' => $token,
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['message']);
    }
}
