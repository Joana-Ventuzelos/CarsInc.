<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_users_exist_with_correct_roles(): void
    // {
    //     $regularUser = \App\Models\User::where('email', 'user@example.com')->first();
    //     $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();

    //     $this->assertNull($regularUser);
    //     $this->assertFalse($regularUser->is_admin);

    //     $this->assertNotNull($adminUser);
    //     $this->assertTrue($adminUser->is_admin);
    // }
}
