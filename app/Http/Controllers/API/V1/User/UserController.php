<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\V1\User\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $inputs = $request->validated();
        $user = User::where('id', Auth::id())->with(['posts', 'postUserLikes'])->firstOrFail();
        $user->update($inputs);
        return response()->json($user);
    }
}
