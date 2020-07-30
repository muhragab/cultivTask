<?php

namespace Tests\Unit;

use App\Models\V1\User;
use Faker\Factory;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_can_create_user()
    {
        $faker = Factory::create();
        $data = [
            'username' => $faker->address,
            'email' => $faker->email,
            'password' => $faker->address,
        ];
        $this->post(route('users.store'), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_can_update_user()
    {

        $user = factory(User::class)->create();

        $faker = Factory::create();
        $data = [
            'username' => $faker->address,
            'email' => $faker->email,
            'password' => $faker->address,
        ];

        $this->put(route('users.update', $user->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
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

        $this->delete(route('users.delete', $user->id))
            ->assertStatus(204);
    }

    public function test_can_list_users()
    {
        $users = factory(User::class, 2)->create()->map(function ($user) {
            return $user->only(['username', 'email', 'password']);
        });

        $this->get(route('users'))
            ->assertStatus(200)
            ->assertJson($users->toArray())
            ->assertJsonStructure([
                '*' => ['username', 'email', 'password'],
            ]);
    }
}