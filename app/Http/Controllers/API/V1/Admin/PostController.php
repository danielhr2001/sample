<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\StorePostRequest;
use App\Http\Requests\API\V1\Admin\UpdatePostRequest;

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
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $inputs = $request->validated();
        $new_post = Post::create($inputs);
        return response()->json($new_post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($post_id)
    {
        $post = Post::where('id', $post_id)->with(['postUserLikes', 'user'])->firstOrFail();
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $post_id)
    {
        $inputs = $request->validated();
        $post = Post::where('id', $post_id)->with(['user:id,name', 'postUserLikes'])->firstOrFail();
        $post->update($inputs);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(["message" => "پست با موفقیت پاک شد"]);
    }
}
