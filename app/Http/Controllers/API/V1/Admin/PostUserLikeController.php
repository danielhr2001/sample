<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\PostUserLike;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\StorePostUserLikeRequest;

class PostUserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post_user_likes = PostUserLike::with(['post','user:id,name'])->paginate();
        return response()->json($post_user_likes);
    }
}
