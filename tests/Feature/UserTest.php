<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //ユーザー作成
    public function test_user_can_be_created()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        //データベースにユーザーが存在することを確認
        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);
    }


    public function test_email_must_unique()
    {
        //一人目のユーザー作成
        User::factory()->create([
            'email' => 'dulicate@example.com',
        ]);

        //同じメールアドレスで2人目を作成しようとした時に例外が発生
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => 'dulicate@example.com',
        ]);
    }
}
