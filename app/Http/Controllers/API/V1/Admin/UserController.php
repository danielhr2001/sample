<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\StoreUserRequest;
use App\Http\Requests\API\V1\Admin\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->validated();
        $new_user = User::create($input);
        return response()->json($new_user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $user = User::where('id', $user_id)->with(['posts', 'postUserLikes', 'OTPs'])->firstOrFail();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        $input = $request->validated();
        $user = User::where('id', $user_id)->with(['posts', 'postUserLikes', 'OTPs'])->firstOrFail();
        $user->update($input);
        return response()->json($user);
    }
}
