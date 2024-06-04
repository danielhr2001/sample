<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\Post;
use App\Models\PostUserLike;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\V1\User\StorePostUserLikeRequest;

class PostUserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::whereHas('postUserLikes', function ($query) {
            $query->where('user_id', Auth::id());
        })->paginate();

        return response()->json($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostUserLikeRequest $request)
    {
        $inputs = $request->validated();
        $post_user_like = PostUserLike::create($inputs);
        return response()->json($post_user_like, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostUserLike $postUserLike)
    {
        $this->authorize('delete', $postUserLike);
        $postUserLike->delete();
        return response()->json(["message" => "از لایک در اومد."]);
    }
}
