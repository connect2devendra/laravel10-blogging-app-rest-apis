<?php

namespace Tests\Unit\Api;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;


class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;   
    
    
    public function test_show_validation_error_when_login_credential_fields_empty()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Validation Error.',
        ]);
    }

    public function test_show_invalid_credential_error_when_credential_donot_match()
    {
        $response = $this->json('POST', route('auth.login'), [
            'email' => 'test2@test.com',
            'password' => 'test1232'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials',
            ]);
    }

   
    public function test_return_user_and_token_after_successful_login()
    {
        $user = User::factory()->create([
            'name' => 'John doe',
            'email' => 'johndoe@example.org',
            'password' => Hash::make('testpassword')
        ]);

        $response = $this->actingAs($user)->json('POST', route('auth.login'), [
            'email' =>'johndoe@example.org',
            'password' => 'testpassword',
        ]);

        // dd($response); 

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token',
                ]
            ]);
    }

    public function test_show_user_registration_form_validation_error_when_name_email_password_fields_empty()
    {
        $emptyData = [
                        'name' => '',
                        'email' => '',
                        'password' => ''
                    ];

        $response = $this->postJson(route('auth.register'), $emptyData, ['Accept' => 'application/json']);

        $response->assertStatus(422)
                ->assertJson([
                    'success' => false,
                    'message' => 'Validation Error.',
                ]);
    }

    public function test_return_userdetails_after_successful_register()
    {
        $userData = [
                    'name' => 'John doe',
                    'email' => 'johndoe@example.org',
                    'password' => Hash::make('testpassword')
                ];

        $response = $this->json('POST', route('auth.register'), $userData, ['Accept' => 'application/json']);

        $response->assertStatus(201)
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
       
}

