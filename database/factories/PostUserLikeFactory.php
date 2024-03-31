<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostUserLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostUserLike>
 */
class PostUserLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flag=true;
        while($flag){
            $user = User::inRandomOrder()->first();
            $post = Post::where('user_id','!=',$user->id)->inRandomOrder()->first();
            $like = PostUserLike::where('user_id',$user->id)->where('post_id',$post->id)->first();
            if(!isset($like)){
                $flag = !$flag;
            }
        }
        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ];
    }
}
