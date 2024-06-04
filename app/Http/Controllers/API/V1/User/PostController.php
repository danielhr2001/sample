<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\V1\User\StorePostRequest;
use App\Http\Requests\API\V1\User\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->paginate();
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
        $post = Post::where('id', $post_id)->with(['user', 'postUserLikes'])->firstOrFail();
        $this->authorize('view', $post);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request,$post_id)
    {
        $inputs = $request->validated();
        $post = Post::where('id', $post_id)->with(['user:id,name', 'postUserLikes'])->firstOrFail();
        $this->authorize('update', $post);
        $post->update($inputs);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(["message" => "پست با موفقیت پاک شد"]);
    }
}
