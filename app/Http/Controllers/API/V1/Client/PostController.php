<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Models\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate();
        return response()->json($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }
}
