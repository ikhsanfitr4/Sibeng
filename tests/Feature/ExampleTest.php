<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
     use RefreshDatabase;
    /** @test */
    public function home_redirects_to_login()
    {
        $this->get('/')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function login_page_can_be_accessed()
    {
        $this->get('/login')
            ->assertStatus(200);
    }

    /** @test */
    public function owner_route_redirect_if_not_logged_in()
    {
        $this->get('/owner/dashboard')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function owner_route_forbidden_for_non_owner()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get('/owner/dashboard')
            ->assertStatus(403);
    }

    /** @test */
    public function owner_can_access_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'owner'
        ]);

        $this->actingAs($user)
            ->get('/owner/dashboard')
            ->assertStatus(200);
    }

    /** @test */
    public function admin_route_redirect_if_not_logged_in()
    {
        $this->get('/admin/dashboard')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_route_forbidden_for_invalid_role()
    {
        $user = User::factory()->create([
            'role' => 'mekanik'
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }

    /** @test */
    public function owner_can_access_admin_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'owner'
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }
}