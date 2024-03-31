<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(40)->create()
            ->each(function ($user) {
                $user_post_count = rand(3, 10);
                for ($i = 0; $i < $user_post_count; $i++) {
                    Post::factory()->create([
                        'user_id' => $user->id,
                    ]);
                }
            });
    }
}
