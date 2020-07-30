<?php

namespace Tests\Unit;

use App\Models\V1\Admin;
use App\Models\V1\Post;
use App\Models\V1\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use JWTAuth;

class AuthTest extends TestCase
{
    use WithoutMiddleware; // use this trait

    public function test_can_login_admin()
    {
        $this->withoutExceptionHandling();
        $admin = \factory(Admin::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($admin, 'admins');
        $token = JWTAuth::fromUser($admin);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];

        $faker = Factory::create();
        $data = [
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ];
        $this->post(url('api/v1/admin/login'), $data)
            ->assertStatus(200);
    }

    public function test_can_login_user()
    {
        $this->withoutExceptionHandling();
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($user, 'users');
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];

        $faker = Factory::create();
        $data = [
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ];
        $this->post(url('api/v1/user/login'), $data)
            ->assertStatus(200);
    }

}