<?php

namespace Tests\Unit;

use App\Models\V1\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use WithoutMiddleware; // use this trait

    public function test_can_create_user()
    {
        $faker = Factory::create();
        $password = $faker->email;
        $data = [
            'username' => $faker->titleMale,
            'email' => $faker->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this->post(route('users.store'), $data)
            ->assertStatus(200);
    }

    public function test_can_update_user()
    {
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $data = [
            'username' => 'test1@testcas1e.com',
            'email' => 'tes1t@1testcase.com',
            'password' => '1test@tes1tcase.com',
            'password_confirmation' => '1test@tes1tcase.com',
        ];
        $this->patch(route('users.update', $user->id), $data)
            ->assertStatus(200);
        /*    ->assertJson($data);*/
    }

    public function test_can_show_user()
    {

        $user = factory(User::class)->create();

        $this->get(route('users.show', $user->id))
            ->assertStatus(200);
    }

    public function test_can_delete_user()
    {

        $user = factory(User::class)->create();

        $this->delete(route('users.destroy', $user->id))
            ->assertStatus(200);
    }

    public function test_can_list_users()
    {
        /*$users = factory(User::class, 5)->create();*/
        $this->get(route('users.index'))
            ->assertStatus(200);
    }
}
