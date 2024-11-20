<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate();
        return new PostCollection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show($post_id)
    {
        $post = Post::with('user')->find($post_id);
        return new PostResource($post->loadCount('postUserLikes'));
    }
}
