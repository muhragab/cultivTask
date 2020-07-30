<?php

namespace Tests\Unit;

use App\Models\V1\Post;
use App\Models\V1\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use JWTAuth;

class PostTest extends TestCase
{
    use WithoutMiddleware; // use this trait

    public function test_can_create_post()
    {
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
            'title' => $faker->title,
            'post' => $faker->text,
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(200);
    }

    public function test_can_update_post()
    {
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($user, 'users');
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];
        $post = \factory(Post::class)->create([
            'title' => 'title',
            'post' => 'text',
        ]);
        $data = [
            'title' => 'test title',
            'post' => 'test text',
        ];

        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(200);
    }

    public function test_can_show_post()
    {
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($user, 'users');
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];
        $post = factory(Post::class)->create();
        $this->get(route('posts.show', $post->id))
            ->assertStatus(200);
    }

    public function test_can_delete_post()
    {
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($user, 'users');
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];

        $post = factory(Post::class)->create();

        $this->delete(route('posts.destroy', $post->id))
            ->assertStatus(200);
    }

    public function test_can_list_posts()
    {
        $user = \factory(User::class)->create([
            'username' => 'test@testcase.com',
            'email' => 'test@testcase.com',
            'password' => 'test@testcase.com',
        ]);
        $this->actingAs($user, 'users');
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token", 'Accept' => 'application/json'];

        $posts = factory(Post::class, 2)->create()->map(function ($post) {
            return $post->only(['id', 'title', 'content']);
        });

        $this->get(route('posts.index'))
            ->assertStatus(200);
    }
}