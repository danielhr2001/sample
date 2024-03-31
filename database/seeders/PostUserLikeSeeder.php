<?php

namespace Database\Seeders;

use App\Models\PostUserLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostUserLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostUserLike::factory(150)->create();
    }
}
